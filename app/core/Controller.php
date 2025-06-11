<?php
class Controller {

    protected function model($model) {
        require_once "../app/models/$model.php";
        return new $model();
    }

    protected function view($view, $data = []) {
        require_once "../app/views/$view.php";
    }

    protected function redirect($url, $permanent = false) {
        if (headers_sent() === false) {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }

        exit();
    }

    protected function siteUrl($location) {

        $http = (empty($_SERVER['HTTPS']) ? 'http' : 'https');

        $url =  "$http://{$_SERVER["HTTP_HOST"]}/checklists/public/";

        return $url . $location;
    }

    protected function fullUrl() {

        $protocol   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host       = $_SERVER['HTTP_HOST'];
        $requestUri = $_SERVER['REQUEST_URI'];

        $urlCompleta = $protocol . $host . $requestUri;

        return $urlCompleta;
    }

    protected function processData() {

        $method = $_SERVER['REQUEST_METHOD'];
        $data = [];

        if ($method === 'POST') {
            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if (strpos($contentType, 'application/json') === 0) {
                // A requisição é em formato JSON
                $json = file_get_contents('php://input');
                $data = json_decode($json, true); // Decodifica JSON em array associativo
            } else {
                // A requisição é um formulário normal
                $data = $_POST;
            }
        } elseif ($method === 'GET') {
            $data = $_GET;
        }

        return $data;

    }

    protected function validateFields($fields) {
        $data          = $this->processData();

        $validatedData = [];
        $errors        = [];

        foreach ($fields as $fieldName => $options) {

            $value = $data[$fieldName] ?? null;

            if (isset($options['cleanHtml']) && $options['cleanHtml'] === true) {
                $value = strip_tags($value);
            }

            if (isset($options['cleanSpecial']) && $options['cleanSpecial'] === true) {
                $value = preg_replace('/[^\p{L}\p{N}\s]/u', '', $value);
            }

            if (isset($options['toUpper']) && $options['toUpper'] === true) {
                $value = mb_strtoupper($value);
            }

            if (isset($options['onlyNumbers']) && $options['onlyNumbers'] === true) {
                $value = preg_replace('/\D/', '', $value);
            }

            $validationResult = $this->applyValidation($value, $options);

            if ($validationResult !== true) {
                if (isset($options["fieldLabel"]))
                    $errors[$options["fieldLabel"]] = $validationResult;
                else
                    $errors[$fieldName] = $validationResult;
            } else {
                $validatedData[$fieldName] = $value;
            }
        }

        return [
            'valid'  => empty($errors),
            'data'   => $validatedData,
            'errors' => $errors
        ];
    }

    protected function applyValidation($value, $options) {
        $errors = [];

        foreach ($options as $option => $rule) {
            switch ($option) {
                case 'required':
                    if ($value == null) {
                        $errors[] = ' é obrigatório.';
                    }
                    break;
                case 'int':
                    if (!is_int($value) && !ctype_digit($value)) {
                        $errors[] = ' deve ser um número inteiro.';
                    }
                    break;

                case 'float':
                    if (!is_float($value) && !is_numeric($value)) {
                        $errors[] = ' deve ser um número decimal.';
                    }
                    break;

                case 'email':
                    if ($value != "" && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = ' não é um endereço de email válido.';
                    }
                    break;

                case 'min':
                    if (is_numeric($value) && $value < $rule) {
                        $errors[] = ' deve ser pelo menos ' . $rule . '.';
                    }
                    break;

                case 'max':
                    if (is_numeric($value) && $value > $rule) {
                        $errors[] = ' não pode ser maior que ' . $rule . '.';
                    }
                    break;

                case 'minLength':
                    if (is_string($value) && $value != "" && strlen($value) < $rule) {
                        $errors[] = ' deve ter pelo menos ' . $rule . ' caracteres.';
                    }
                    break;

                case 'maxLength':
                    if (is_string($value) && strlen($value) > $rule) {
                        $errors[] = ' não pode exceder ' . $rule . ' caracteres.';
                    }
                    break;

                case 'fieldLabel':
                case 'cleanHtml':
                case 'cleanSpecial':
                case 'toUpper':
                case 'onlyNumbers':
                    break;

                default:
                    $errors[] = 'Regra de validação inválida especificada.';
            }
        }

        return empty($errors) ? true : $errors;
    }

    protected function showErrors($errors) {
        $alertMessage = "<strong>Erro!</strong>";
        foreach ($errors as $field => $errs) {
            foreach ($errs as $error) {
                $alertMessage .= " '$field': $error";
            }
        }
        $_SESSION["alertClass"]   = "danger";
        $_SESSION["alertMessage"] = $alertMessage;
    }

    protected function alertSuccess() {
        $_SESSION["alertClass"]   = "success";
        $_SESSION["alertMessage"] = "Operação realizada com sucesso!";
    }

    protected function postRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
            return true;

        return false;
    }

    protected function getRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            return true;

        return false;
    }

    function mask($val, $mask){

        $maskared   = '';
        $k          = 0;
        $t          = strlen($mask);

        if ( strlen($val) == $t )
            return $val;

        for($i = 0; $i <= $t -1; $i++) {
            if($mask[$i] == '#'){
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}
?>
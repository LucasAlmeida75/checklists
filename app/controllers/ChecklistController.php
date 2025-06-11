<?php
    class ChecklistController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("auth/entrar"));
        }

        public function detalhes($id = null) {
            if ($id == null) {
                try {
                    $id  = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

                    $obj = $this->model('Checklist');

                    $obj->insert(['id' => $id, 'description' => 'Nova Checklist']);

                    $this->redirect($this->siteUrl("checklist/detalhes/$id"));
                } catch (PDOException $e) {
                    die("Erro ao buscar checklists: " . $e->getMessage());
                }
            } else {
                try {
                    $obj = $this->model('Checklist');
                    $data['checklist'] = $obj->searchById($id)["result"];

                    if (!is_array($data["checklist"])) {
                        $this->redirect($this->siteUrl("checklist/detalhes"));
                    } else {
                        $obj = $this->model('ChecklistItem');
                        $data['checklistsItem'] = $obj->searchById($id)["result"];
                    }

                    if (!is_array($data["checklistsItem"])) {
                        $data["checklistsItem"] = [];
                    }

                } catch (PDOException $e) {
                    die("Erro ao buscar checklists: " . $e->getMessage());
                }
            }

            $data["urlForm"] = $this->siteUrl("checklist/salvar/$id");

            $this->view("structure/header");
            $this->view("checklist/detalhes", $data);
            $this->view("structure/footer");
        }

        public function salvar($id = null) {
            if ($this->postRequest()) {

                $this->validateProjeto($dados, $errors);

                if (empty($errors)) {

                    try {
                        $obj = $this->model('Checklist');

                        $checklist = $obj->searchById($id)['result'];
                        if (is_array($checklist)) {
                            $obj->updateById($id, $dados);

                            if (isset($dados['']))
                            $obj = $this->model('ChecklistItem');

                        }
                    } catch (PDOException $e) {
                        die("Erro ao atualizar checklist: " . $e->getMessage());
                    }
                } else {
                    echo json_encode($errors);
                    //$this->redirect($this->siteUrl("checklist/detalhes/$id"));
                }
            }
        }

        public function validateProjeto(&$dados = [], &$errors = []) {
            $fieldsToValidate = [
                'idChecklist' => [
                    "fieldLabel"   => "ID do checklist",
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "minLength"    => 0,
                    "maxLength"    => 50
                ],
                'descriptionChecklist' => [
                    "fieldLabel"   => "Descrição do checklist",
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "minLength"    => 0,
                    "maxLength"    => 450
                ],
                'idItem' => [
                    "fieldLabel"   => "ID do item",
                    "onlyNumbers"  => true,
                    "minLength"    => 0,
                    "maxLength"    => 250
                ],
                'concluded' => [
                    "fieldLabel"   => "Item concluído",
                    "onlyNumbers"  => true,
                    "minLength"    => 0,
                    "maxLength"    => 1
                ],
                'description' => [
                    "fieldLabel"   => "Descrição do item",
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "minLength"    => 0,
                    "maxLength"    => 450
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $dados  = $validationResults['data'];
            } else {
                $errors = $validationResults['errors'];
            }
        }

        public function removeCustomer($id) {
            try {
                $obj = $this->model('Checklist');
                $obj->removeById($id);
            } catch (PDOException $e) {
                die("Erro ao remover checklist: " . $e->getMessage());
            }
        }
    }
?>
<?php
class ChecklistController extends Controller
{
    private $request;

    public function __construct()
    {
        $this->request = $this->request('checklist');
    }

    public function index()
    {
        $this->redirect($this->siteUrl("auth/entrar"));
    }

    public function detalhes($id = null)
    {
        if ($id == null) {
            $this->criarNovaChecklist();
        } else {
            $data = $this->buscarChecklist($id);

            $this->view("structure/header");
            $this->view("checklist/detalhes", $data);
            $this->view("structure/footer");
        }
    }

    public function salvarChecklist($id)
    {
        if ($this->postRequest()) {

            $dados = $this->request->validateChecklist();

            try {
                $obj = $this->model('Checklist');

                $checklist = $obj->searchById($id)['result'];
                if (is_array($checklist)) {
                    $obj->updateById($id, $dados);
                }
            } catch (PDOException $e) {
                die("Erro ao atualizar checklist: " . $e->getMessage());
            }
        }
    }

    public function salvarChecklistItem($id = null)
    {
        if ($this->postRequest()) {

            $dados = $this->request->validateChecklistItem();

            try {
                $obj = $this->model('ChecklistItem');

                if ($id != null) {
                    $item = $obj->searchById($id, $dados);

                    if (is_array($item) && count($item)) {
                        $obj->updateById($id, $dados);
                    }
                } else {
                    $id = $obj->insert($dados)['result'];
                }

                echo json_encode(['id' => $id]);
            } catch (PDOException $e) {
                die("Erro ao atualizar item da checklist: " . $e->getMessage());
            }
        }
    }

    public function salvarPosicoes()
    {
        if ($this->postRequest()) {
            $dados = $this->request->validatePositions();

            if (is_array($dados)) {
                try {
                    $obj = $this->model('ChecklistItem');

                    foreach ($dados as $dadosItem) {

                        $item = $obj->searchById($dadosItem['itemId'], $dadosItem);

                        if (is_array($item) && count($item)) {
                            $obj->updatePosition($dadosItem);
                        }
                    }

                } catch (PDOException $e) {
                    die("Erro ao atualizar posições dos itens: " . $e->getMessage());
                }
            }
        }
    }

    private function criarNovaChecklist()
    {
        try {
            $id  = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

            $obj = $this->model('Checklist');

            $obj->insert(['id' => $id, 'description' => 'Nova Checklist']);

            $this->redirect($this->siteUrl("checklist/detalhes/$id"));
        } catch (PDOException $e) {
            die("Erro ao buscar checklists: " . $e->getMessage());
        }
    }

    private function buscarChecklist($id)
    {
        try {
            $obj = $this->model('Checklist');
            $data['checklist'] = $obj->searchById($id)["result"];

            if (!is_array($data["checklist"])) {
                $this->redirect($this->siteUrl("checklist/detalhes"));
            } else {
                $obj = $this->model('ChecklistItem');
                $data['checklistsItem'] = $obj->searchByChecklistId($id)["result"];
            }

            if (!is_array($data["checklistsItem"])) {
                $data["checklistsItem"] = [];
            }

            return $data;
        } catch (PDOException $e) {
            die("Erro ao buscar checklists: " . $e->getMessage());
        }
    }

    public function deleteChecklistItem($id)
    {
        try {
            $dados = $this->request->validateDelete();

            if (isset($dados['lastUrlElement'])) {
                $obj = $this->model('ChecklistItem');
                $obj->deleteById($id);
            }
        } catch (PDOException $e) {
            die("Erro ao remover checklist: " . $e->getMessage());
        }
    }
}

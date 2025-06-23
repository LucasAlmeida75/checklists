<?php
class ChecklistRequest extends Controller
{
    public function validateChecklist()
    {
        $fieldsToValidate = [
            'lastUrlElement' => [
                'fieldLabel'   => 'ID da checklist',
                'required'     => true,
                'cleanHtml'    => true,
                'cleanSpecial' => true,
                'minLength'    => 6,
                'maxLength'    => 50
            ],
            'descriptionChecklist' => [
                'fieldLabel'   => 'Descrição da checklist',
                'required'     => true,
                'cleanHtml'    => true,
                'cleanSpecial' => true,
                'minLength'    => 0,
                'maxLength'    => 450
            ]
        ];

        return $this->validateEngine($fieldsToValidate);
    }

    public function validateChecklistItem()
    {
        $fieldsToValidate = [
            'lastUrlElement' => [
                'fieldLabel'   => 'ID do item',
                'onlyNumbers'  => true,
            ],
            'idChecklist' => [
                'fieldLabel'   => 'ID da checklist',
                'required'     => true,
                'cleanHtml'    => true,
                'cleanSpecial' => true,
                'minLength'    => 6,
                'maxLength'    => 50
            ],
            'concluded' => [
                'fieldLabel'   => 'Item concluído',
                'required'     => true,
                'onlyNumbers'  => true,
                'minLength'    => 0,
                'maxLength'    => 1
            ],
            'description' => [
                'fieldLabel'   => 'Descrição do item',
                'required'     => true,
                'cleanHtml'    => true,
                'cleanSpecial' => true,
                'minLength'    => 0,
                'maxLength'    => 450
            ],
            'position' => [
                'fieldLabel'   => 'Posição',
                'required'     => true,
                'onlyNumbers'  => true
            ]
        ];

        return $this->validateEngine($fieldsToValidate);
    }

    public function validatePositions() {
        $fieldsToValidate = [
            'idChecklist' => [
                'fieldLabel'   => 'ID da checklist',
                'required'     => true,
                'cleanHtml'    => true,
                'cleanSpecial' => true,
                'minLength'    => 6,
                'maxLength'    => 50
            ],
            'itemId' => [
                'fieldLabel'   => 'ID do item',
                'onlyNumbers'  => true,
            ],
            'position' => [
                'fieldLabel'   => 'Posição',
                'required'     => true,
                'onlyNumbers'  => true
            ]
        ];

        return $this->validateEngine($fieldsToValidate);
    }

    public function validateDelete() {
        $fieldsToValidate = [
            'lastUrlElement' => [
                'fieldLabel'   => 'ID do item da checklist',
                'required'     => true,
                'onlyNumbers'  => true,
                'minLength'    => 0,
            ]
        ];

        return $this->validateEngine($fieldsToValidate);
    }
}

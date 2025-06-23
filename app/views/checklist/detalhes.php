
<input type="hidden" id="idChecklist" value="<?php echo $data['checklist']['id']; ?>">
<div class="mb-3">
    <input type="text" class="form-control input-checklist" id="descriptionChecklist" required value="<?php echo $data['checklist']['description']; ?>">
</div>

<div class="mb-3 checklist-items">
    <label for="item_description" class="form-label">Itens da Checklist</label>
    <?php if (count($data['checklistsItem']) > 0) { ?>
        <?php foreach ($data['checklistsItem'] as $checklist) { ?>
            <div class="input-group mb-2">
                <input type="hidden" class="idItem" value="<?php echo $checklist['id']; ?>">
                <input type="hidden" class="position" value="<?php echo $checklist['position']; ?>">
                <div class="input-group-text">
                    <input class="form-check-input mt-0 checkbox" type="checkbox" value="1" <?php if ($checklist['is_concluded']) echo 'checked'; ?>>
                </div>
                <input type="text" class="form-control description <?php if ($checklist['is_concluded']) echo 'itemConcluded'; ?>" value="<?php echo $checklist['description']; ?>">
                <div class="input-group-text">
                    <button type="button" class="btn btn-danger btn-sm btnRemoveChecklist"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="input-group mb-2">
            <input type="hidden" class="idItem" value="">
            <input type="hidden" class="position" value="">
            <div class="input-group-text">
                <input class="form-check-input mt-0 checkbox" type="checkbox" value="1">
            </div>
            <input type="text" class="form-control description" value="Novo item">
            <div class="input-group-text">
                <button type="button" class="btn btn-danger btn-sm btnRemoveChecklist"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    <?php } ?>
</div>

<div class="mb-3">
    <button type="button" id="btnAddChecklist" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i></button>
</div>

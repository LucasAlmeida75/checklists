
<input type="hidden" id="idChecklist" value="<?php echo $data['checklist']['id']; ?>">
<div class="mb-3">
    <input type="text" class="form-control input-checklist" id="descriptionChecklist" required value="<?php echo $data['checklist']['description']; ?>">
</div>

<div class="mb-3 checklist-items">
    <label for="item_description" class="form-label">Itens da Checklist</label>
    <?php if (count($data['checklistsItem']) > 0) { ?>
        <?php foreach ($data['checklistsItem'] as $checklist) { ?>
            <div class="input-group mb-2">
                <input type="hidden" class="idItem" id="idItem" value="<?php echo $checklist['id']; ?>">
                <div class="input-group-text">
                    <input class="form-check-input mt-0 checkbox" type="checkbox" id="concluded" value="<?php echo $checklist['is_concluded'] ? 1 : 0; ?>">
                </div>
                <input type="text" class="form-control description" id="description" value="<?php echo $checklist['description']; ?>">
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="input-group mb-2">
            <input type="hidden" class="idItem" id="idItem" value="">
            <div class="input-group-text">
                <input class="form-check-input mt-0 checkbox" type="checkbox" id="concluded" value="0">
            </div>
            <input type="text" class="form-control description" id="description" value="Novo item">
        </div>
    <?php } ?>
</div>

<div class="mb-3">
    <button type="button" id="btnAddChecklist" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i></button>
</div>

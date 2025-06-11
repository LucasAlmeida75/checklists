document.addEventListener('DOMContentLoaded', () => {
    const btnAddChecklist = document.querySelector("#btnAddChecklist");

    if (btnAddChecklist) {
        btnAddChecklist.addEventListener("click", function() { createChecklist(); });
    }

    const checklistItems = document.querySelectorAll(".idItem, .checkbox, .description");

    if (checklistItems) {
        checklistItems.forEach((element) => {
            element.addEventListener("blur", function() { saveChecklist(this); });
        });
    }

    const btnRemoverCliente = document.querySelectorAll(".btnRemoverCliente");

    if (btnRemoverCliente) {
        btnRemoverCliente.forEach((element, index) => { element.addEventListener("click", function(e) { removeCustomer(index); }) });
    }
});

function createChecklist() {
    const checklistItemsContainer = document.querySelector('.checklist-items');
    if (checklistItemsContainer) {
        const itemHtml = `
            <div class="input-group mb-2">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" name="concluded[]" value="1">
                </div>
                <input type="text" class="form-control" name="item_description[]" value="Novo Item">
            </div>
        `;
        checklistItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
    }
}

function saveChecklist(element) {
    const idChecklist          = document.querySelector("#idChecklist").value;
    const descriptionChecklist = document.querySelector("#descriptionChecklist").value;
    const idItem               = element.closest('.input-group').querySelector('.idItem')?.value || '';
    const concluded            = element.closest('.input-group').querySelector('.checkbox')?.checked ? 1 : 0;
    const description          = element.closest('.input-group').querySelector('.description')?.value || '';

    const data = {
        idChecklist,
        descriptionChecklist,
        idItem,
        concluded,
        description
    };

    fetch(`${baseUrl}/checklist/salvar/${idChecklist}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => {
        return processResponse(response);
    })
    .then(data => {
        if (data && Object.keys(data).length > 0) {
            showErrors(data);
        }
    })
    .catch(error => {
        console.error('Erro ao validar campos:', error);
    });
}
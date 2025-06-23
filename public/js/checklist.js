document.addEventListener('DOMContentLoaded', () => {
    const btnAddChecklist = document.querySelector("#btnAddChecklist");
    if (btnAddChecklist) {
        btnAddChecklist.addEventListener("click", function() { createChecklist(); });
    }

    const checklist = document.querySelector("#descriptionChecklist");
    if (checklist) {
        checklist.addEventListener("blur", function() { saveChecklist(); });
    }

    const checklistItems = document.querySelectorAll(".idItem, .checkbox, .description");
    if (checklistItems) {
        checklistItems.forEach((element) => {
            element.addEventListener("blur", function() { saveChecklistItem(this); });
        });
    }

    const checkbox = document.querySelectorAll('.checkbox');
    if (checkbox) {
        checkbox.forEach((element) => {
            element.addEventListener('click', function() { itemConcluded(this); });
        });
    }

    const btnRemoveChecklist = document.querySelectorAll(".btnRemoveChecklist");
    btnRemoveChecklist.forEach((element) => {
        element.addEventListener('click', function() { removeChecklistItem(this); });
    })

    sortableChecklistItems();
});

function createChecklist() {
    const checklistItemsContainer = document.querySelector('.checklist-items');
    if (checklistItemsContainer) {
        const position = document.querySelectorAll('.position').length + 1;
        const itemHtml = `
            <div class="input-group mb-2">
                <input type="hidden" class="idItem" id="idItem" value="">
                <input type="hidden" class="position" id="position" value="${position}">
                <div class="input-group-text">
                    <input class="form-check-input mt-0 checkbox" type="checkbox" id="concluded" value="1">
                </div>
                <input type="text" class="form-control description" id="description" value="Novo item">
                <div class="input-group-text">
                    <button type="button" class="btn btn-danger btn-sm btnRemoveChecklist"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        `;
        checklistItemsContainer.insertAdjacentHTML('beforeend', itemHtml);

        const checklistItems = document.querySelectorAll(".idItem, .checkbox, .description");
        let lastItem = checklistItems[checklistItems.length - 1];
        if (lastItem) {
            lastItem.addEventListener("blur", function() { saveChecklistItem(this); });
        }

        const checkbox = document.querySelectorAll('.checkbox');
        lastItem = checkbox[checkbox.length - 1];
        if (lastItem) {
            lastItem.addEventListener('click', function() { itemConcluded(this); });
        }

        const btnRemoveChecklist = document.querySelectorAll(".btnRemoveChecklist");
        lastItem = btnRemoveChecklist[btnRemoveChecklist.length - 1];
        if (lastItem) {
            lastItem.addEventListener('click', function() { removeChecklistItem(this); });
        }
    }
}

function itemConcluded(element) {

    const father1 = element.parentNode;
    const father2 = father1.parentNode;
    const checklistLabel = father2.querySelector('.description');
    if (element.checked) {
        checklistLabel.classList.add('itemConcluded');
    } else {
        checklistLabel.classList.remove('itemConcluded');
    }
}

function saveChecklist() {
    const idChecklist = document.querySelector("#idChecklist").value;
    const descriptionChecklist = document.querySelector("#descriptionChecklist").value;

    const data = {
        descriptionChecklist
    };

    fetch(`${baseUrl}/checklist/salvarChecklist/${idChecklist}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => {
            return processResponse(response);
        })
        .then(data => {
            if (data && data.errors && Object.keys(data.errors).length > 0) {
                return showErrors(data.errors);
            }
        })
        .catch(error => {
            console.error('Erro ao validar campos:', error);
        });
}

function saveChecklistItem(element) {
    const idChecklist = document.querySelector("#idChecklist").value;
    const idItem      = element.closest('.input-group').querySelector('.idItem')?.value || '';
    const concluded   = element.closest('.input-group').querySelector('.checkbox')?.checked ? 1 : 0;
    const description = element.closest('.input-group').querySelector('.description')?.value || '';
    const position    = element.closest('.input-group').querySelector('.position')?.value || '';

    const data = {
        idChecklist,
        idItem,
        concluded,
        description,
        position
    };

    fetch(`${baseUrl}/checklist/salvarChecklistItem/${idItem}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => {
            return processResponse(response);
        })
        .then(data => {
            if (data && data.errors && Object.keys(data.errors).length > 0) {
                return showErrors(data.errors);
            }
            element.closest('.input-group').querySelector('.idItem').value = data.id;
        })
        .catch(error => {
            console.error('Erro ao validar campos:', error);
        });
}

function savePositions() {
    const idChecklist = document.querySelector("#idChecklist").value;
    const data = {};

    document.querySelectorAll('.idItem').forEach((element, i) => {
        const item = {
            itemId: element.value,
            position: element.closest('.input-group').querySelector('.position')?.value || '',
            idChecklist
        }
        data[i] = item;
    });

    fetch(`${baseUrl}/checklist/salvarPosicoes`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => {
            return processResponse(response);
        })
        .then(data => {
            if (data && data.errors && Object.keys(data.errors).length > 0) {
                return showErrors(data.errors);
            }
        })
        .catch(error => {
            console.error('Erro ao validar campos:', error);
        });
}

function removeChecklistItem(element) {
    const confirmed = confirm('Tem certeza que deseja remover o item?');
    const id        = element.closest('.input-group').querySelector('.idItem')?.value || '';

    if (!confirmed)
        return;

    if (id != '') {
        fetch(`${baseUrl}/checklist/deleteChecklistItem/${id}`)
            .then(response => {
                return processResponse(response);
            })
            .then(data => {
                if (data && data.errors && Object.keys(data.errors).length > 0) {
                    return showErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Erro ao validar campos:', error);
            });
    }

    element.closest('.input-group').remove();
}

function sortableChecklistItems() {
    const lista = document.querySelector('.checklist-items');
    const sortable = Sortable.create(lista, {
        animation: 150,
        handle: '.input-group',
        onEnd: function (evt) {
            document.querySelectorAll('.position').forEach((element, i) => {
                element.value = i;
            });

            savePositions();
        }
    });
}
(() => {
    'use strict';

    function checkBoxes(trigger) {
        if (!trigger) {
            return;
        }
        const listItem = trigger.closest('li');
        if (!listItem) {
            return;
        }
        listItem.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.checked = trigger.checked;
        });
    }

    function checkBoxContacts(toggle) {
        const select = document.getElementById('field-contact-search');
        if (!toggle || !select) {
            return;
        }
        const shouldSelectAll = Boolean(toggle.checked);
        Array.from(select.options).forEach((option) => {
            option.selected = shouldSelectAll;
        });
        select.disabled = shouldSelectAll;
    }

    function hydrateContactState() {
        const toggle = document.getElementById('checkbox-all-contacts');
        const select = document.getElementById('field-contact-search');
        if (!toggle || !select) {
            return;
        }
        const selectedOptions = Array.from(select.options).filter((option) => option.selected).length;
        const allSelected = select.options.length > 0 && selectedOptions === select.options.length;
        toggle.checked = allSelected;
        select.disabled = allSelected;
    }

    function initCategoryTree() {
        document.querySelectorAll('.category_tree input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener('click', (event) => {
                checkBoxes(event.currentTarget);
            });
        });
    }

    function initContactControls() {
        const toggle = document.getElementById('checkbox-all-contacts');
        const select = document.getElementById('field-contact-search');
        if (!toggle || !select) {
            return;
        }
        toggle.addEventListener('change', (event) => {
            checkBoxContacts(event.currentTarget);
        });
        hydrateContactState();
    }

    const TreeFolder = {
        init() {
            document.querySelectorAll('.foldtree').forEach((tree) => {
                TreeFolder.prepare(tree);
            });
        },
        prepare(element, depth = -1) {
            const nextDepth = depth + 1;
            let foldByDefault = true;
            let nestedList = null;
            let checkbox = null;

            Array.from(element.children).forEach((child) => {
                const nodeName = child.nodeName.toLowerCase();
                if (nodeName === 'ul') {
                    nestedList = child;
                    TreeFolder.prepare(child, nextDepth);
                    if (child.querySelector('input[type="checkbox"]:checked')) {
                        foldByDefault = false;
                    }
                    if (foldByDefault && nextDepth > 0) {
                        child.style.display = 'none';
                    }
                } else if (nodeName === 'li') {
                    TreeFolder.prepare(child, nextDepth);
                } else if (nodeName === 'input') {
                    checkbox = child;
                }
            });

            if (checkbox && nestedList) {
                element.classList.toggle('closed', foldByDefault);
                element.classList.toggle('open', !foldByDefault);
                const toggle = document.createElement('a');
                toggle.className = 'foldicon';
                toggle.innerHTML = `<span>${foldByDefault ? '+' : '-'}</span> `;
                element.insertBefore(toggle, checkbox);
                toggle.addEventListener('click', () => {
                    TreeFolder.liAClicked(toggle);
                });
            } else if (checkbox && nextDepth > 2) {
                const spacer = document.createElement('a');
                spacer.className = 'foldicon';
                spacer.innerHTML = '<span>&nbsp;</span>';
                element.insertBefore(spacer, checkbox);
            }
        },
        liAClicked(anchor) {
            const parent = anchor.parentElement;
            if (!parent) {
                return;
            }
            const nestedLists = Array.from(parent.children).filter((child) => child.nodeName.toLowerCase() === 'ul');
            let showList = false;
            nestedLists.forEach((list) => {
                showList = list.style.display === 'none';
                list.style.display = showList ? 'block' : 'none';
            });
            const indicator = anchor.querySelector('span');
            if (indicator) {
                indicator.textContent = showList ? '-' : '+';
            }
            parent.classList.toggle('open', showList);
            parent.classList.toggle('closed', !showList);
        }
    };

    function focusActiveRow() {
        const activeRow = document.querySelector('.active');
        if (!activeRow) {
            return;
        }
        const message = document.querySelector('.typo3-messages');
        let scrollTarget = activeRow;
        if (message) {
            activeRow.insertAdjacentHTML('beforebegin', '<tr id="t3message" class="active"><td colspan="9"> ' + message.innerHTML + '</td></tr>');
            scrollTarget = document.getElementById('t3message') || activeRow;
        }
        if (scrollTarget.scrollIntoView) {
            scrollTarget.scrollIntoView();
        }
    }

    function onDomReady() {
        initCategoryTree();
        initContactControls();
        TreeFolder.init();
        focusActiveRow();
    }

    document.addEventListener('DOMContentLoaded', onDomReady);

    // expose helpers for legacy templates/tests
    window.checkBoxes = checkBoxes;
    window.checkBoxContacts = checkBoxContacts;
})();

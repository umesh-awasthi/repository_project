document.addEventListener('DOMContentLoaded', function () {
    const roleDropdown = document.getElementById('role_id');
    const selectAllCheckbox = document.getElementById('select-all');

    // Select All Checkbox Event
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            let isChecked = this.checked;
            
            document.querySelectorAll('.parent-checkbox, .child-checkbox').forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            
            updatePermissions(); // Update backend
        });
    }

    // Parent Checkbox Event
    document.querySelectorAll('.parent-checkbox').forEach(parent => {
        parent.addEventListener('change', function () {
            let prefix = this.dataset.prefix;
            let isChecked = this.checked;
            
            document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]`).forEach(child => {
                child.checked = isChecked;
            });

            syncSelectAllCheckbox();
            updatePermissions(); // Update backend
        });
    });

    // Child Checkbox Event
    document.querySelectorAll('.child-checkbox').forEach(child => {
        child.addEventListener('change', function () {
            let prefix = this.dataset.prefix;
            let parentCheckbox = document.querySelector(`.parent-checkbox[data-prefix="${prefix}"]`);
            let allChecked = document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]:checked`).length === 
                             document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]`).length;
            
            parentCheckbox.checked = allChecked; // Auto-check parent if all children are checked
            syncSelectAllCheckbox();
            updatePermissions();
        });
    });

    // Sync Select All Checkbox
    function syncSelectAllCheckbox() {
        let totalCheckboxes = document.querySelectorAll('.child-checkbox').length;
        let checkedCheckboxes = document.querySelectorAll('.child-checkbox:checked').length;
        
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = totalCheckboxes === checkedCheckboxes;
        }
    }

    // Update Database with AJAX
    function updatePermissions() {
        let roleId = roleDropdown.value;
        if (!roleId) return;

        let permissions = [];
        document.querySelectorAll('.child-checkbox:checked').forEach(checkbox => {
            permissions.push(checkbox.value);
        });

        fetch(assignPermissionUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ role_id: roleId, permission_id: permissions })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.json();
        })
        .then(data => {
            console.log("Permissions Updated:", data);
        })
        .catch(error => {
            console.error("Error updating permissions:", error);
        });
    }

    // Fetch Permissions for Selected Role
    roleDropdown.addEventListener('change', function () {
        let roleId = this.value;
        if (!roleId) {
            console.error("No role selected.");
            return;
        }

        fetch(`/admin/get-permissions/${roleId}`)
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                document.querySelectorAll('.child-checkbox').forEach(checkbox => {
                    checkbox.checked = data.includes(parseInt(checkbox.value));
                });

                // Sync Parent Checkboxes
                document.querySelectorAll('.parent-checkbox').forEach(parent => {
                    let prefix = parent.dataset.prefix;
                    let allChecked = document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]:checked`).length === 
                                     document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]`).length;
                    parent.checked = allChecked;
                });
                
                syncSelectAllCheckbox();
            })
            .catch(error => {
                console.error("Error fetching permissions:", error);
            });
    });
});
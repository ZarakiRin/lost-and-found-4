document.addEventListener("DOMContentLoaded", function () {
    // Search and Filter Functionality
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const tableRows = document.querySelectorAll("table tr:not(:first-child)");

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const lastName = row.children[1].textContent.toLowerCase();
            const firstName = row.children[2].textContent.toLowerCase();
            const middleName = row.children[3].textContent.toLowerCase();
            const facultyId = row.children[4].textContent.toLowerCase();
            const email = row.children[5].textContent.toLowerCase();
            const username = row.children[6].textContent.toLowerCase();
            const role = row.children[7].textContent.toLowerCase();

            const matchesSearch = lastName.includes(searchTerm) || 
                                firstName.includes(searchTerm) || 
                                middleName.includes(searchTerm) || 
                                facultyId.includes(searchTerm) || 
                                email.includes(searchTerm) || 
                                username.includes(searchTerm);
            
            const matchesRole = selectedRole === "" || role.includes(selectedRole);

            row.style.display = matchesSearch && matchesRole ? "" : "none";
        });
    }

    searchInput.addEventListener("input", filterTable);
    roleFilter.addEventListener("change", filterTable);

    const modal = document.getElementById("addAdminModal");
    const openBtn = document.getElementById("openModal");
    const closeBtn = document.getElementById("closeModal");
    const pageContent = document.getElementById("pageContent");

   
    openBtn.onclick = function () {
        modal.style.display = "flex";
        pageContent.classList.add("blurred");
    };

    closeBtn.onclick = function () {
        modal.style.display = "none";
        pageContent.classList.remove("blurred");
    };

    //  EDIT form
    const editModal = document.getElementById("editAdminModal"); 
    const closeEditBtn = document.getElementById("closeEditModal");

    // All edit buttons
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("edit_admin_id").value = this.dataset.id;
            document.getElementById("edit_last_name").value = this.dataset.lastName;
            document.getElementById("edit_first_name").value = this.dataset.firstName;
            document.getElementById("edit_middle_name").value = this.dataset.middleName;
            document.getElementById("edit_faculty_id").value = this.dataset.facultyId;
            document.getElementById("edit_email").value = this.dataset.email;
            document.getElementById("edit_username").value = this.dataset.username;

            // ✅ New: role instead of status
            document.getElementById("edit_role").value = this.dataset.role;

            editModal.style.display = "flex";
            pageContent.classList.add("blurred");
        });
    });

    closeEditBtn.onclick = function () {
        editModal.style.display = "none";
        pageContent.classList.remove("blurred");
    };

    // ✅ Close modals when clicking outside
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            pageContent.classList.remove("blurred");
        }
        if (event.target === editModal) {
            editModal.style.display = "none";
            pageContent.classList.remove("blurred");
        }
    };
});

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".delete-btn").forEach(button => {
    button.addEventListener("click", function() {
      let form = this.closest("form");
      Swal.fire({
        title: "Are you sure?",
        text: "This admin will be deleted permanently.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
});

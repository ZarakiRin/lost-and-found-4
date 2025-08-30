document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("addAdminModal");
    const openBtn = document.getElementById("openModal");
    const closeBtn = document.getElementById("closeModal");
    const pageContent = document.getElementById("pageContent");

    // ✅ ADD MODAL
    openBtn.onclick = function () {
        modal.style.display = "flex";
        pageContent.classList.add("blurred");
    };

    closeBtn.onclick = function () {
        modal.style.display = "none";
        pageContent.classList.remove("blurred");
    };

    // ✅ EDIT form
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

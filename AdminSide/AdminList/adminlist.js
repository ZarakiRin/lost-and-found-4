document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("addAdminModal");
    const openBtn = document.getElementById("openModal");
    const closeBtn = document.getElementById("closeModal");
    const pageContent = document.getElementById("pageContent");

    // ✅ADD MODAL
    openBtn.onclick = function () {
        modal.style.display = "flex";
        pageContent.classList.add("blurred");
    };

    closeBtn.onclick = function () {
        modal.style.display = "none";
        pageContent.classList.remove("blurred");
    };

    // EDIT form 2
    const editModal = document.getElementById("editAdminModal"); 
    const closeEditBtn = document.getElementById("closeEditModal");

    // eto edit buttons
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", function () {
           document.getElementById("edit_admin_id").value = this.dataset.id;
            document.getElementById("edit_last_name").value = this.dataset.lastName;
            document.getElementById("edit_first_name").value = this.dataset.firstName;
            document.getElementById("edit_middle_name").value = this.dataset.middleName;
            document.getElementById("edit_faculty_id").value = this.dataset.facultyId;
            document.getElementById("edit_email").value = this.dataset.email;
            document.getElementById("edit_username").value = this.dataset.username;


            editModal.style.display = "flex";
            pageContent.classList.add("blurred");
        });
    });

    closeEditBtn.onclick = function () {
        editModal.style.display = "none";
        pageContent.classList.remove("blurred");
    };

    // Close modals btn
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

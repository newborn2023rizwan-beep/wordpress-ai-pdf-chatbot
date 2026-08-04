document.addEventListener("DOMContentLoaded", function () {
  // =========================
  // Upload PDF
  // =========================

  const uploadForm = document.getElementById("wpaipdf-upload-form");

  if (uploadForm) {
    uploadForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const formData = new FormData(uploadForm);
      formData.append("action", "wpaipdf_upload_pdf");

      fetch(ajaxurl, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((response) => {
          if (!response.success) {
            alert(response.data);
            return;
          }

          alert(response.data.message);
          location.reload();
        })
        .catch((error) => {
          console.error(error);
          alert("Upload failed.");
        });
    });
  }

  // =========================
  // Delete PDF
  // =========================

  document.querySelectorAll(".wpaipdf-delete-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      console.log("ID:", this.dataset.id);
      console.log("PATH:", this.dataset.path);

      if (!confirm("Are you sure you want to delete this PDF?")) {
        return;
      }

      const formData = new FormData();

      formData.append("action", "wpaipdf_delete_pdf");
      formData.append("id", this.dataset.id);
      formData.append("path", this.dataset.path);

      fetch(ajaxurl, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((response) => {
          console.log(response);

          if (!response.success) {
            alert(response.data);
            return;
          }

          alert(response.data.message);
          location.reload();
        })
        .catch((error) => {
          console.error(error);
          alert("Delete failed.");
        });
    });
  });
});

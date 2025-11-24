let currentReservationId = null;
function loadReservationDetail(id) {
  currentReservationId = id;
  document.getElementById("detailContent").innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading reservation details...</p>
                </div>
            `;
  fetch("get_reservation_detail.php?id=" + id)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      document.getElementById("detailContent").innerHTML = data;
    })
    .catch((error) => {
      document.getElementById("detailContent").innerHTML =
        '<div class="alert alert-danger">Error loading reservation details. Please try again.</div>';
      console.error("Error:", error);
    });
}
function editReservation() {
  if (!currentReservationId) {
    alert("No reservation selected");
    return;
  }
  const detailModal = bootstrap.Modal.getInstance(
    document.getElementById("detailModal")
  );
  if (detailModal) {
    detailModal.hide();
  }
  document.getElementById("editContent").innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading edit form...</p>
                </div>
            `;
  fetch("get_edit_form.php?id=" + currentReservationId)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      document.getElementById("editContent").innerHTML = data;
      // menunjukan edit modal
      const editModal = new bootstrap.Modal(
        document.getElementById("editModal")
      );
      editModal.show();
    })
    .catch((error) => {
      document.getElementById("editContent").innerHTML =
        '<div class="alert alert-danger">Error loading edit form. Please try again.</div>';
      console.error("Error:", error);
    });
}
function deleteReservation() {
  if (!currentReservationId) {
    alert("No reservation selected");
    return;
  }
  if (
    confirm(
      "Are you sure you want to delete this reservation? This action cannot be undone."
    )
  ) {
    window.location.href =
      "reservation_tables.php?delete_id=" + currentReservationId;
  }
}
document.addEventListener("DOMContentLoaded", function () {
  const filterForms = document.querySelectorAll(
    'form[id$="FilterForm"], form#sortForm'
  );
  filterForms.forEach((form) => {
    const selects = form.querySelectorAll("select");
    selects.forEach((select) => {
      select.addEventListener("change", function () {
        form.submit();
      });
    });
  });
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function () {
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        submitBtn.disabled = true;
      }
    });
  });
});
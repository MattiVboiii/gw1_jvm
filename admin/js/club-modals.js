const modal = document.querySelector("#modal-club-description");

modal?.addEventListener("show.bs.modal", (event) => {
  const button = event.relatedTarget;
  const paragraph = button?.nextElementSibling;
  const clubName = button?.getAttribute("data-club-name");
  const clubDesc = paragraph?.textContent;
  const title = modal.querySelector("#club-description-label");
  const desc = modal.querySelector(".modal-body > p");

  title.textContent = `Description: ${clubName}`;
  desc.textContent = clubDesc;
});

const deletionModal = document.querySelector("#modal-club-deletion");

deletionModal?.addEventListener("show.bs.modal", (event) => {
  const button = event.relatedTarget;
  const clubId = button?.getAttribute("data-club-id");
  const clubName = button?.getAttribute("data-club-name");
  const title = deletionModal.querySelector("#club-deletion-label");
  const desc = deletionModal.querySelector(".modal-body > p");
  const inputClubId = deletionModal.querySelector("#inputDeletionClubId");
  const inputClubName = deletionModal.querySelector("#inputDeletionClubName");

  inputClubId.value = clubId;
  inputClubName.value = clubName;
  title.textContent = `DELETING: ${clubName}`;
  desc.innerHTML = `Are you sure you want to delete the following club?<br><br>   <strong class="p-3 fw-bold">#${clubId}: ${clubName}</strong><br><br>This action is irreversible!`;
});

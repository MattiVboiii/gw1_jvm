const modal = document.querySelector('[id="modal-management-deletion"]');

modal?.addEventListener("show.bs.modal", (event) => {
  const button = event.relatedTarget;
  const idM = button?.getAttribute("data-idM");
  const role = button?.getAttribute("data-role");
  const firstNameM = button?.getAttribute("data-firstNameM");
  const lastNameM = button?.getAttribute("data-lastNameM");
  const desc = modal.querySelector(".modal-body > p");
  const inputRoleDeletionId = modal.querySelector("#inputRoleDeletionId");
  const inputRoleNameD = modal.querySelector("#inputRoleNameD");
  const inputFirstNameD = modal.querySelector("#inputFirstNameD");
  const inputLastNameD = modal.querySelector("#inputLastNameD");

  inputRoleDeletionId.value = idM;
  inputRoleNameD.value = role;
  inputFirstNameD.value = firstNameM;
  inputLastNameD.value = lastNameM;
  desc.innerHTML = `Are you sure you want to delete the following role?<br><br>   <strong class="p-3 fw-bold">#${idM}: ${role} - ${firstNameM} ${lastNameM}</strong><br><br>This action is irreversible!`;
});

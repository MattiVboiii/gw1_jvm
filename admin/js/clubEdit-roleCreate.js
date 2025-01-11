const showBtn = document.querySelector("#btn-showRoleCreate");
const accordion = document.querySelector("#managementCreateAccordion");
const btnAccordion = accordion?.querySelector(".accordion-button");
const accordionCollapse = accordion?.querySelector("#collapse-create");

showBtn?.addEventListener("click", () => {
  accordion.classList.remove("d-none");
  btnAccordion.classList.remove("collapsed");
  btnAccordion.setAttribute("aria-expanded", true);
  accordionCollapse.classList.add("show");
});

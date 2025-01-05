const logoBtn = document.querySelector("#btn-logo-preview");

logoBtn.addEventListener("click", () => {
  const logoImg = document.querySelector("#img-logo");
  const logoUrlInput = document.querySelector("#inputLogoUrl");
  const url = logoUrlInput.value;

  if (url) logoImg.setAttribute("src", url);
});

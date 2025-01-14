const form = document.querySelector("form:has(#advanced-search)");
const advancedSearch = document.querySelector("#advanced-search");
const toggle = document.querySelector(".advanced-search-toggle");
const submit = document.querySelector(
  "form:has(#advanced-search) button[type='submit']"
);

if (localStorage.getItem("expanded")) {
  form.classList.add("expanded");
}

toggle.addEventListener("click", async () => {
  if (localStorage.getItem("expanded")) {
    localStorage.removeItem("expanded");
    form.classList.remove("expanded");
  } else {
    localStorage.setItem("expanded", "expanded");
    form.classList.add("expanded");
  }
});

document.addEventListener("DOMContentLoaded", async () => {
  if (localStorage.getItem("expanded")) {
    await sleep(1);
  }
  advancedSearch.style.transition = "all 1s";
});

function sleep(time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

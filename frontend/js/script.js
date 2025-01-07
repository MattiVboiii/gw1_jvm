console.log("javascript works on frontend.......");

// Toggle sort direction
function toggleSortDirection(event) {
  const currentDirection = document.querySelector(
    'input[name="sortDirection"]'
  ).value;
  const newDirection = currentDirection === "asc" ? "desc" : "asc";
  document.querySelector('input[name="sortDirection"]').value = newDirection;
  const button = event.target;
  button.textContent = newDirection === "asc" ? "↑ Ascending" : "↓ Descending";
}

document
  .querySelector(".toggleSortDirection")
  .addEventListener("click", toggleSortDirection);

// Update text on slider input change
document
  .querySelector(".clubsPerPageSlider")
  .addEventListener("input", (event) => {
    document.getElementById("clubsPerPageValue").textContent =
      event.target.value;
  });

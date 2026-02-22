
let selectedSession = null;

function filterSessions(date, element) {

  document
    .querySelectorAll(".date-card")
    .forEach((el) => el.classList.remove("active"));
  element.classList.add("active");


  document
    .querySelectorAll(".sessions-day-group")
    .forEach((el) => (el.style.display = "none"));


  const targetGroup = document.getElementById("sessions-" + date);
  if (targetGroup) {
    targetGroup.style.display = "flex";
  }


  clearSessionSelection();
}


function selectSession(element) {

  document
    .querySelectorAll(".session-item")
    .forEach((el) => el.classList.remove("selected"));


  element.classList.add("selected");


  selectedSession = {
    id: element.dataset.sessionId,
    date: element.dataset.sessionDate,
    time: element.dataset.sessionTime,
  };


  const sessionInput = document.getElementById("session-id-input");
  if (sessionInput) sessionInput.value = selectedSession.id;


  const hint = document.getElementById("booking-hint");
  const selection = document.getElementById("booking-selection");
  const btnBook = document.getElementById("btn-book");

  if (hint) hint.style.display = "none";
  if (selection) {
    selection.style.display = "block";
    selection.innerHTML =
      '<i class="fas fa-check-circle"></i> Séance sélectionnée : <strong>' +
      selectedSession.date +
      " à " +
      selectedSession.time +
      "</strong>";
  }
  if (btnBook) {
    btnBook.classList.add("active");
  }
}

function clearSessionSelection() {
  selectedSession = null;
  document
    .querySelectorAll(".session-item")
    .forEach((el) => el.classList.remove("selected"));

  const hint = document.getElementById("booking-hint");
  const selection = document.getElementById("booking-selection");
  const btnBook = document.getElementById("btn-book");

  if (hint) hint.style.display = "block";
  if (selection) selection.style.display = "none";
  if (btnBook) btnBook.classList.remove("active");
}


document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("booking-form");
  if (form) {
    form.addEventListener("submit", function (event) {
      if (!selectedSession) {
        event.preventDefault();
        const hint = document.getElementById("booking-hint");
        if (hint) {
          hint.classList.add("shake");
          setTimeout(() => hint.classList.remove("shake"), 600);
        }
      }
    });
  }
});

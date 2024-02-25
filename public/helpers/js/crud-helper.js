const myModal = tailwind.Modal.getInstance(
    document.querySelector("#delete-modal-preview")
);
document?.querySelectorAll(".deleteBtn")?.forEach((e) =>
    e.addEventListener("click", function (e) {
        e.preventDefault();
        document.getElementById("deleteForm").action = e.target.href;
        myModal.show();
    })
);

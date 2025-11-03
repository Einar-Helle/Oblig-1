function confirmDelete() {
    const userConfirmed = confirm("Er du sikker?");
    if (userConfirmed) {
        // Perform the delete action
        console.log("Klasse slettet!");
    } else {
        // Cancel the delete action
        console.log("Handling avbrutt.");
    }
}
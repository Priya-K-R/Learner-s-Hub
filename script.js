function filterCards(category , headingId) {
    let cards = document.querySelectorAll(".card");
    // let heading = document.querySelectorAll(".courses-heading"); // Select the heading

    if (category === "all") {
        // Show all headings. For demonstration, we assume all h1 tags should be visible.
        document.querySelectorAll(".courses-heading").forEach(heading => {
          heading.style.display = "block";
        });
      } else {
        // Hide all headings except the one matching headingId.
        document.querySelectorAll(".courses-heading").forEach(heading => {
          heading.style.display = heading.id === headingId ? "block" : "none";
        });
      }

    cards.forEach(card => {
        if (category === "all" ){
            card.style.display = "block";
        }
            else if(card.getAttribute("data-category") === category) {
            card.style.display = "block"; // Show matching cards
        } else {
            card.style.display = "none"; // Hide non-matching cards
        }
    });
}



function filterTestCards(category) {
    let cards = document.querySelectorAll(".aTCard");
    console.log(cards)

    cards.forEach(card => {
        if (category === "all-tests" ){
            console.log(card)
            card.style.display = "block";
        }
            else if(card.getAttribute("data-category") === category) {
            card.style.display = "block"; // Show matching cards
        } else {
            card.style.display = "none"; // Hide non-matching cards
        }
    });
}























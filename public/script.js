document.querySelectorAll("td").forEach(
    t=> t.addEventListener("click", ()=>{
            t.classList.toggle("highlight")
    })
)

document.getElementById("postButton").addEventListener("click", function() {
    const textarea = document.querySelector("textarea");
    const feed = document.querySelector(".feed");

    if (textarea.value.trim() === "") {
        alert("¡Campo Vacío!");
        return;
    }

    const newPost = document.createElement("div");
    newPost.classList.add("post");
    newPost.innerHTML = `<p><strong>Tú</strong>: ${textarea.value}</p>`;
    feed.prepend(newPost);
    textarea.value = ""; // Limpiar el textarea
});

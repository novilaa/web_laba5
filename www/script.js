document.getElementById("subscriptionForm").addEventListener("submit", function(e) {
    const username = document.querySelector("[name='username']").value;
    const journal = document.querySelector("[name='journal']").value;
    alert(`Вы оформили подписку: ${username}, журнал "${journal}"`);
});

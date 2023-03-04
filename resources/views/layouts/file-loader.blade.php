<div class="custom_loader" style="margin-bottom: 16px"></div>

<script>
    (() => {
        const loader = document.querySelectorAll(".custom_loader")[document.querySelectorAll(".custom_loader").length - 1];
        const text = "Обробка файлу";

        let countPoints = "1";

        setInterval(() => {
            countPoints++;
            if (countPoints > 3) countPoints = 0;

            loader.innerHTML = text;
            for (let i = 0; i < countPoints; i++)
                loader.innerHTML += ".";
        }, 500)
    })();
</script>


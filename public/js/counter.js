document.addEventListener("DOMContentLoaded", async function () {
    try {
        const response = await fetch("https://ipapi.co/json/");
        const data = await response.json();

        console.log("IP:", data.ip);
        console.log("City:", data.city);

        const userAgent = navigator.userAgent.toLowerCase();
        let device = "Unknown";

        if (userAgent.includes("mobile")) {
            device = "Mobile";
        } else if (userAgent.includes("tablet")) {
            device = "Tablet";
        } else if (userAgent.includes("win")) {
            device = "Windows PC";
        } else if (userAgent.includes("mac")) {
            device = "Mac";
        } else if (userAgent.includes("linux")) {
            device = "Linux PC";
        }

        console.log("Device:", device);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch("/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                ip: data.ip,
                city: data.city,
                device: device,
            }),
        })
            .then(response => response.json())
            .then(result => {
                console.log("Result:", result);
            })
            .catch(error => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.error("Error fetching IP info:", error);
    }
});

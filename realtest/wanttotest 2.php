<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แจ้งเตือนออเดอร์ใหม่</title>
</head>
<body>
  <h2>🔔 ระบบแจ้งเตือนออเดอร์ใหม่</h2>
  <p>แม้คุณจะเปลี่ยนหน้า/ย่อแท็บ ก็ยังได้แจ้งเตือน</p>

  <script>
    // ขอสิทธิ์แจ้งเตือนเมื่อเข้าเว็บ
    document.addEventListener("DOMContentLoaded", () => {
      if (Notification.permission !== "granted") {
        Notification.requestPermission();
      }
    });

    // ฟังก์ชันแจ้งเตือน
    function notifyOrder(order) {
      if (Notification.permission === "granted") {
        let notification = new Notification("ออเดอร์ใหม่!", {
          body: `หมายเลข #${order.id}: ${order.item}`,
          icon: "https://cdn-icons-png.flaticon.com/512/3595/3595455.png"
        });

        // คลิกที่แจ้งเตือนแล้วเด้งไปหน้ารายละเอียด
        notification.onclick = () => {
          window.open(order.url, "_blank");
        };
      }

      // เล่นเสียงแจ้งเตือน
      let audio = new Audio("https://www.soundjay.com/buttons/sounds/button-3.mp3");
      audio.play();
    }

    // จำลองการมีออเดอร์ใหม่ทุก ๆ 20 วินาที
    setInterval(() => {
      let order = {
        id: Math.floor(Math.random() * 1000),
        item: "ข้าวกะเพราไข่ดาว",
        url: "order-detail.html?id=" + Math.floor(Math.random() * 1000)
      };
      notifyOrder(order);
    }, 20000);
  </script>
</body>
</html>

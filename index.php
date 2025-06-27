
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>МедТех — Продажа медицинского оборудования</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
</head>
<body>

<?php include 'header.php'; ?>

<section class="hero">
  <div class="hero-content">
    <h1>Современное медицинское оборудование</h1>
    <p>Решения для клиник и медицинских центров по всей России</p>
    <a href="catalog.php" class="cta-button">Перейти в каталог</a>
  </div>
</section>

<section class="services">
  <h2>Наши услуги</h2>
  <div class="services-grid">
    <div class="service-card">
      <h3>Поставка оборудования</h3>
      <p>Подберём оптимальные решения под ваши задачи.</p>
    </div>
    <div class="service-card">
      <h3>Сервисное обслуживание</h3>
      <p>Гарантийный и постгарантийный ремонт техники.</p>
    </div>
    <div class="service-card">
      <h3>Обучение специалистов</h3>
      <p>Проводим обучения и семинары по работе с оборудованием.</p>
    </div>
  </div>
</section>

<section class="benefits-section">
  <h2>Наши преимущества</h2>
  <div class="benefits">
    <div class="benefit-item">
      <i class="fa-solid fa-truck-fast"></i>
      <h3>Быстрая доставка</h3>
      <p>Оперативная доставка в любой регион</p>
    </div>
    <div class="benefit-item">
      <i class="fa-solid fa-credit-card"></i>
      <h3>Удобная оплата</h3>
      <p>Принимаем различные способы платежей</p>
    </div>
    <div class="benefit-item">
      <i class="fa-solid fa-hospital"></i>
      <h3>Сертифицированное оборудование</h3>
      <p>Официальные поставки с гарантией</p>
    </div>
    <div class="benefit-item">
      <i class="fa-solid fa-headset"></i>
      <h3>Поддержка клиентов</h3>
      <p>Всегда готовы помочь и проконсультировать</p>
    </div>
  </div>
</section>

<section class="popular">
  <h2>Популярные товары</h2>
  <div id="popular-products" class="products-grid"></div>
</section>

<section class="about-short">
  <h2>О компании</h2>
  <p>Компания МедТех обеспечивает российские клиники современными аппаратами и сервисом. Наша миссия — сделать передовые технологии доступными в каждом регионе.</p>
  <a href="about.php" class="cta-button">Узнать больше</a>
</section>

<section class="reviews">
  <h2>Отзывы клиентов</h2>
  <div class="reviews-carousel">
    <div class="review-card active">
      <p>"Отличный сервис, быстро доставили оборудование."</p>
      <h4>Иван К.</h4>
    </div>
    <div class="review-card">
      <p>"Помогли подобрать нужную модель и отвечали на все вопросы."</p>
      <h4>Мария П.</h4>
    </div>
    <div class="review-card">
      <p>"Качество оборудования на высоте, будем заказывать ещё."</p>
      <h4>Сергей Л.</h4>
    </div>
  </div>
</section>

<section id="contact" class="contact">
  <h2>Связаться с нами</h2>
  <p>Оставьте заявку и мы свяжемся с вами в ближайшее время.</p>
  <form class="contact-form">
    <input type="text" placeholder="Ваше имя" required />
    <input type="email" placeholder="Email для связи" required />
    <textarea rows="4" placeholder="Сообщение" required></textarea>
    <button type="submit" class="cta-button">Отправить</button>
  </form>
</section>

<footer>
  <p>&copy; 2025 МедТех. Все права защищены.</p>
  <p>Телефон: 8 (800) 123-45-67 | Email: <a href="mailto:info@medtech.ru">info@medtech.ru</a></p>
</footer>

<script src="products.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("popular-products");
    const popular = products.slice(0, 4);
    popular.forEach(product => {
      const card = document.createElement("div");
      card.className = "product-card";
      card.innerHTML = `
        <img src="${product.img}" alt="${product.name}">
        <h3>${product.name}</h3>
        <p>${product.price.toLocaleString()} ₽</p>
        <button onclick="addToCart(${product.id})">В корзину</button>
      `;
      container.appendChild(card);
    });

    const form = document.querySelector('.contact-form');
    if (form) {
      form.addEventListener('submit', e => {
        e.preventDefault();
        form.innerHTML = '<p class="success">Спасибо! Мы свяжемся с вами.</p>';
      });
    }

    const reviews = document.querySelectorAll('.review-card');
    let rIndex = 0;
    if (reviews.length) {
      setInterval(() => {
        reviews[rIndex].classList.remove('active');
        rIndex = (rIndex + 1) % reviews.length;
        reviews[rIndex].classList.add('active');
      }, 5000);
    }
  });
</script>
<script src="header.js"></script>
<script src="session.js"></script>

</body>
</html>

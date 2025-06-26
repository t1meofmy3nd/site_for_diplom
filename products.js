const products = [
    { id: 1, name: 'УЗИ модель 1', brand: 'Brand 1', category: 'УЗИ', price: 125000, img: 'images/uzi1.jpg' },
  { id: 2, name: 'УЗИ модель 2', brand: 'Brand 2', category: 'УЗИ', price: 150000, img: 'images/uzi2.jpg' },
  { id: 3, name: 'УЗИ модель 3', brand: 'Brand 3', category: 'УЗИ', price: 175000, img: 'images/uzi3.jpg' },
  { id: 4, name: 'УЗИ модель 4', brand: 'Brand 4', category: 'УЗИ', price: 200000, img: 'images/uzi4.jpg' },
  { id: 5, name: 'УЗИ модель 5', brand: 'Brand 5', category: 'УЗИ', price: 225000, img: 'images/uzi5.jpg' },
  { id: 6, name: 'УЗИ модель 6', brand: 'Brand 6', category: 'УЗИ', price: 250000, img: 'images/uzi6.jpg' },
  { id: 7, name: 'Рентген модель 1', brand: 'Brand 1', category: 'Рентген', price: 125000, img: 'images/rentgen1.jpg' },
  { id: 8, name: 'Рентген модель 2', brand: 'Brand 2', category: 'Рентген', price: 150000, img: 'images/rentgen2.jpg' },
  { id: 9, name: 'Рентген модель 3', brand: 'Brand 3', category: 'Рентген', price: 175000, img: 'images/rentgen3.jpg' },
  { id: 10, name: 'Рентген модель 4', brand: 'Brand 4', category: 'Рентген', price: 200000, img: 'images/rentgen4.jpg' },
  { id: 11, name: 'Рентген модель 5', brand: 'Brand 5', category: 'Рентген', price: 225000, img: 'images/rentgen5.jpg' },
  { id: 12, name: 'Рентген модель 6', brand: 'Brand 6', category: 'Рентген', price: 250000, img: 'images/rentgen6.jpg' },
  { id: 13, name: 'Дефибрилляторы модель 1', brand: 'Brand 1', category: 'Дефибрилляторы', price: 125000, img: 'images/defib1.jpg' },
  { id: 14, name: 'Дефибрилляторы модель 2', brand: 'Brand 2', category: 'Дефибрилляторы', price: 150000, img: 'images/defib2.jpg' },
  { id: 15, name: 'Дефибрилляторы модель 3', brand: 'Brand 3', category: 'Дефибрилляторы', price: 175000, img: 'images/defib3.jpg' },
  { id: 16, name: 'Дефибрилляторы модель 4', brand: 'Brand 4', category: 'Дефибрилляторы', price: 200000, img: 'images/defib4.jpg' },
  { id: 17, name: 'Дефибрилляторы модель 5', brand: 'Brand 5', category: 'Дефибрилляторы', price: 225000, img: 'images/defib5.jpg' },
  { id: 18, name: 'Дефибрилляторы модель 6', brand: 'Brand 6', category: 'Дефибрилляторы', price: 250000, img: 'images/defib6.jpg' },
  { id: 19, name: 'ЭКГ модель 1', brand: 'Brand 1', category: 'ЭКГ', price: 125000, img: 'images/ekg1.jpg' },
  { id: 20, name: 'ЭКГ модель 2', brand: 'Brand 2', category: 'ЭКГ', price: 150000, img: 'images/ekg2.jpg' },
  { id: 21, name: 'ЭКГ модель 3', brand: 'Brand 3', category: 'ЭКГ', price: 175000, img: 'images/ekg3.jpg' },
  { id: 22, name: 'ЭКГ модель 4', brand: 'Brand 4', category: 'ЭКГ', price: 200000, img: 'images/ekg4.jpg' },
  { id: 23, name: 'ЭКГ модель 5', brand: 'Brand 5', category: 'ЭКГ', price: 225000, img: 'images/ekg5.jpg' },
  { id: 24, name: 'ЭКГ модель 6', brand: 'Brand 6', category: 'ЭКГ', price: 250000, img: 'images/ekg6.jpg' },
  { id: 25, name: 'Мониторы модель 1', brand: 'Brand 1', category: 'Мониторы', price: 125000, img: 'images/monitor1.jpg' },
  { id: 26, name: 'Мониторы модель 2', brand: 'Brand 2', category: 'Мониторы', price: 150000, img: 'images/monitor2.jpg' },
  { id: 27, name: 'Мониторы модель 3', brand: 'Brand 3', category: 'Мониторы', price: 175000, img: 'images/monitor3.jpg' },
  { id: 28, name: 'Мониторы модель 4', brand: 'Brand 4', category: 'Мониторы', price: 200000, img: 'images/monitor4.jpg' },
  { id: 29, name: 'Мониторы модель 5', brand: 'Brand 5', category: 'Мониторы', price: 225000, img: 'images/monitor5.jpg' },
  { id: 30, name: 'Мониторы модель 6', brand: 'Brand 6', category: 'Мониторы', price: 250000, img: 'images/monitor6.jpg' },
];
function addToCart(id) {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  const item = products.find(p => p.id === id);
  const existing = cart.find(p => p.id === id);
  if (existing) existing.quantity += 1;
  else cart.push({ ...item, quantity: 1 });
  localStorage.setItem("cart", JSON.stringify(cart));
}

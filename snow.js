const snowflakes = 60;
for (let i = 0; i < snowflakes; i++) {
  const snowflake = document.createElement('div');
  snowflake.classList.add('snowflake');
  snowflake.textContent = '❄';
  snowflake.style.left = Math.random() * 100 + 'vw';
  snowflake.style.animationDuration = 5 + Math.random() * 10 + 's';
  snowflake.style.fontSize = 10 + Math.random() * 20 + 'px';
  document.body.appendChild(snowflake);
}
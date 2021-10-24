// Корневой url
let siteUrl = window.location.origin;
// Получение списка файлов
async function getDownloads() {
  const res = fetch(`${siteUrl}/api/downloads/`)
    .then((res) => {
      document.querySelector('.loader__wrapper').style.display = 'block'
      return res.json()
    })
    .then((json) => {
      document.querySelector('.loader__wrapper').style.display = 'none'
      return this.array = json
    })
  let result = await res.json();
  console.log(result)
  result.forEach((item) => {
    document.querySelector('.download').insertAdjacentHTML('beforeend', `
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Файл: <span>${item.filename}</span></h5>

        <a href="${siteUrl}/api/getfile?filename=${item.filename}" id="btn" class="btn btn-primary">Скачать</a>
      </div>
    </div>`)
  })
}
getDownloads()

// отправка файла
document.querySelector('form').addEventListener('submit', async function (e) {
  e.preventDefault()

  let formData = new FormData();
  formData.append("file", document.querySelector('.form-control-file').files[0]);
  console.log(formData.get('file'))
  const res = await fetch(`${siteUrl}/api/upload`, {
    method: 'POST',
    body: formData
  })
  console.log(res)
  if(res.status == 200 || res.status == 201) {
    alert('Файл отправлен!')
  }else if(res.status = 409){
    alert('Такой файл уже существует')
  }
  else {
    alert('Ошибк отправки файла!')
  }
  document.querySelector('.download').innerHTML = '';
  document.getElementById("form").reset();
  getDownloads();
})

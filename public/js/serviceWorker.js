// Define um nome para o cache
const meuAmigoPet = "meu-amigo-pet"

// Lista de recursos a serem armazenados em cache
const assets = [
  "/"
]

// Evento de instalação do service worker
self.addEventListener("install", installEvent => {
  // Espera até que o cache seja aberto e os recursos sejam adicionados a ele
  installEvent.waitUntil(
    caches.open(meuAmigoPet).then(cache => {
      cache.addAll(assets)
    })
  )
})

// Evento de busca de recursos (fetch) pelo navegador
self.addEventListener("fetch", fetchEvent => {
  // Intercepta a solicitação de busca de recurso
  fetchEvent.respondWith(
    // Tenta encontrar a solicitação no cache
    caches.match(fetchEvent.request).then(res => {
      // Retorna a resposta do cache se encontrada, caso contrário, faz a solicitação à rede
      return res || fetch(fetchEvent.request)
    })
  )
})

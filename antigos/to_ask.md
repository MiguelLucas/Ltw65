- Verificações de input. Php ou javascript? Ou ambos?
- Conexões à db não funcionam em alguns casos (Miguel). Porquê? DONE
- Comentários. Segundo descrição, um user tem que estar registado no evento para o poder comentar. Não seria melhor qualquer user poder comentar um evento público, desde que esteja logged in? DONE (Sim, podemos ajustar os extras sugeridos como quisermos)
- Acentos na DB? Foreign keys não é guardado, levando a colapso da DB
- FKs estão desligadas por defeito. Na consola, após serem ligadas, verifica-se o efeito cascade (p.ex. apagar um evento apaga os registos associados). Se apagar o evento pelo browser, os registos não são apagados. What gives?
- (Mariana) Depois de criar um evento e ser redireccionado, se o user fizer Back retorna ao "create event", preenchido com os dados do evento acabado de criar. Como posso evitar que o user não aceda à página através do Back?
  - No Edit não se verifica, pois o pedido é feito na mesma página e esvazia recarrega a secção.
  - Related: Após Edit ou Create, se fizer Back até ao index, o evento alterado/adicionado não é carregado. Como posso fazer isto?

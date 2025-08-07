# Simulação de PR
- Para mostrar que passou nos testes automatizados FAKE, enviar uma nova migration ou alterar
- Para mostrar que falhou nos testes automatizados FAKE, não enviar nenhuma migration ou alterar.

# Testes realizados
- Teste limpo, sem migration, terá testes falhado - Adicionou a flag failed e falhou o action
- - "Corrigido", foi adicionado algo em migration - Removeu a flag failed e adicionou success
- - Aplicado pode quebrar o sistema - Aplicou a flag breaking changes
- - Removido pode quebrar o sistema - Removeu a flag breaking changes
- - Adicionado prioridade normal - Nada fez
- - Adicionado prioridade n/a - Nada fez
- - Adicionado prioridade crítica - Adicionou a flag Critic
- - Removido prioridade critica - Removeu flag Critic
- - Adicionado NÂO em testado por QA - Nada fez
- - Adicionado SIM em testado por QA - Adicionou a label QA Validated


# Para a criação de pull no auto
- Habilitar: https://github.com/dilneiss/gitflow-staging/settings/actions

# Testes com feature flag
### Flagsmith
- Acesso: https://app.flagsmith.com
- SDK: https://github.com/Flagsmith/flagsmith-php-client
- Prós: Fácil de usar, sistema muito simples
- Cons: Não possui sdk oficial, sistema de cache não salva as variáveis necessárias em cache para usar posteriormente, 
ias não estão funcionando corretamente o conhecimento que elas tem do sdk não oficial.
- Final: Testar outras opções, dá pra usar adaptando bem ao nosso cenário tranquilo, mas se as outras opções
funcionarem melhor, acredito ser melhor escolha.

### Unleash
- Documentação para instalação: https://docs.getunleash.io/quickstart?_gl=1*17a6ws9*_gcl_au*MTA4ODE4MDg2Ni4xNzM4ODY1NTY3*_ga*MzkyNDEyMzQ4LjE3Mzg4NjU1Njc.*_ga_492KEZQRT8*MTczOTgyMDA5Mi4yLjEuMTczOTgyMDEwMy40OS4wLjA.
- Prós: Tem métricas de quantidade de vezes que a feature foi vista, dashboard para saber quais features estão em funcionamento e em quanto tempo,
vai ajudar muito tomar decisões se a feature foi muito testada ou pouco testada antes de liberar para todo mundo.
- Gradual rollout: 50%, nem toda requisição vai ativar essa feature no mesmo projeto, é aleatório

### testes
abc
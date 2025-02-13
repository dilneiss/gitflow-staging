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
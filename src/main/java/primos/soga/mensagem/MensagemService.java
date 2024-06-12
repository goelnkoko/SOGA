package primos.soga.mensagem;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.UUID;

@Service
public class MensagemService {

    @Autowired
    private MensagemRepository mensagemRepository;

    public Mensagem enviarMensagem(Mensagem mensagem) {
        mensagem.setDataEnvio(LocalDateTime.now());
        return mensagemRepository.save(mensagem);
    }

    public List<Mensagem> getMensagensPorRemetente(UUID remetenteId) {
        return mensagemRepository.findByRemetenteId(remetenteId);
    }

    public List<Mensagem> getMensagensPorDestinatario(UUID destinatarioId) {
        return mensagemRepository.findByDestinatarioId(destinatarioId);
    }

    public List<Mensagem> getMensagensEntreUsuarios(UUID remetenteId, UUID destinatarioId) {
        return mensagemRepository.findByRemetenteIdAndDestinatarioId(remetenteId, destinatarioId);
    }

    public Mensagem atualizarMensagem(UUID id, Mensagem detalhesMensagem) {
        Mensagem mensagem = mensagemRepository.findById(id)
                .orElseThrow(() -> new IllegalStateException("Mensagem não encontrada"));
        mensagem.setConteudo(detalhesMensagem.getConteudo());
        mensagem.setDataEnvio(LocalDateTime.now());
        return mensagemRepository.save(mensagem);
    }

    public void deletarMensagem(UUID id) {
        Mensagem mensagem = mensagemRepository.findById(id)
                .orElseThrow(() -> new IllegalStateException("Mensagem não encontrada"));
        mensagemRepository.delete(mensagem);
    }

    //TODO. Cuidar das excessões
}

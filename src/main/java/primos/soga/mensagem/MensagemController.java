package primos.soga.mensagem;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.UUID;

@RestController
@RequestMapping("/mensagens")
public class MensagemController {

    @Autowired
    private MensagemService mensagemService;

    @PostMapping
    public Mensagem enviarMensagem(@RequestBody Mensagem mensagem) {
        return mensagemService.enviarMensagem(mensagem);
    }

    @GetMapping("/remetente/{remetenteId}")
    public List<Mensagem> getMensagensPorRemetente(@PathVariable UUID remetenteId) {
        return mensagemService.getMensagensPorRemetente(remetenteId);
    }

    @GetMapping("/destinatario/{destinatarioId}")
    public List<Mensagem> getMensagensPorDestinatario(@PathVariable UUID destinatarioId) {
        return mensagemService.getMensagensPorDestinatario(destinatarioId);
    }

    @GetMapping("/conversa/{remetenteId}/{destinatarioId}")
    public List<Mensagem> getMensagensEntreUsuarios(@PathVariable UUID remetenteId, @PathVariable UUID destinatarioId) {
        return mensagemService.getMensagensEntreUsuarios(remetenteId, destinatarioId);
    }

    @PutMapping("/{id}")
    public Mensagem atualizarMensagem(@PathVariable UUID id, @RequestBody Mensagem detalhesMensagem) {
        return mensagemService.atualizarMensagem(id, detalhesMensagem);
    }

    @DeleteMapping("/{id}")
    public void deletarMensagem(@PathVariable UUID id) {
        mensagemService.deletarMensagem(id);
    }
}

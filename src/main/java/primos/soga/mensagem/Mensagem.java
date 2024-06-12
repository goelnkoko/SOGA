package primos.soga.mensagem;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.user.User;

import java.time.LocalDateTime;
import java.util.UUID;

@Data
@Entity
public class Mensagem {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;

    @ManyToOne
    @JoinColumn(name = "remetente_id", nullable = false)
    private User remetente;

    @ManyToOne
    @JoinColumn(name = "destinatario_id", nullable = false)
    private User destinatario;

    private String conteudo;
    private LocalDateTime dataEnvio;
}

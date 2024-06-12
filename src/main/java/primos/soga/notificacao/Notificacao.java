package primos.soga.notificacao;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.user.User;

import java.time.LocalDateTime;
import java.util.Date;
import java.util.UUID;

@Data
@Entity
public class Notificacao {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;

    @ManyToOne
    @JoinColumn(name = "usuario_id")
    private User usuario;

    private String conteudo;
    private LocalDateTime dataNotificacao;
}

package primos.soga.pedidoamizade;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.pedidoamizade.enums.PedidoAmizadeStatus;
import primos.soga.user.User;

import java.time.LocalDateTime;
import java.util.UUID;

@Data
@Entity
public class PedidoAmizade {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;

    @ManyToOne
    @JoinColumn(name = "remetente_id")
    private User remetente;

    @ManyToOne
    @JoinColumn(name = "destinatario_id")
    private User destinatario;

    private String mensagem;
    @Enumerated(EnumType.STRING)
    private PedidoAmizadeStatus status;
    private LocalDateTime dataPedido;
}

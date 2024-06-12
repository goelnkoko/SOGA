package primos.soga.amizade;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.user.User;

import javax.persistence.*;
import java.time.LocalDateTime;
import java.util.UUID;

@Data
@Entity
public class Amizade {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;

    @ManyToOne
    @JoinColumn(name = "usuario1_id")
    private User usuario1;

    @ManyToOne
    @JoinColumn(name = "usuario2_id")
    private User usuario2;

    @Enumerated(EnumType.STRING)
    private AmizadeStatus status;
    private LocalDateTime dataDeConexao;
}

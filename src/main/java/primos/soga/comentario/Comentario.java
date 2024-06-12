package primos.soga.comentario;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.user.User;

import javax.persistence.*;
import java.time.LocalDateTime;
import java.util.List;
import java.util.UUID;

@Data
@Entity

public class Comentario {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;

    @ManyToOne
    @JoinColumn(name = "autor_id")
    private User autor;

    @ManyToOne
    @JoinColumn(name = "publicacao_id")
    private Publicacao publicacao;

    @ElementCollection
    private List<String> conteudo;

    private LocalDateTime dataCriacao;
    private LocalDateTime dataAtualizacao;
}
}

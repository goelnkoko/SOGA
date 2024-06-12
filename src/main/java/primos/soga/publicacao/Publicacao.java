package primos.soga.publicacao;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.comentario.Comentario;
import primos.soga.user.User;

import java.time.LocalDateTime;
import java.util.UUID;
import java.util.List;

@Data
@Entity
public class Publicacao {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;

    @ManyToOne
    @JoinColumn(name = "autor_id")
    private User autor;

    private LocalDateTime dataCriacao;
    private LocalDateTime dataAtualizacao;
    @ElementCollection
    private List<String> conteudo;

    @OneToMany(mappedBy = "publicacao")
    private List<Comentario> comentarios;
}

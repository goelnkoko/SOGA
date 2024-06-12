package primos.soga.user;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.perfil.Perfil;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.UUID;

@Data
@Entity
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;
    private String nome;
    private String username;
    private String email;
    private String telefone;
//    @Enumerated(EnumType.STRING)
//    private UserStatus status;
    private LocalDateTime dataCriacao;
    private LocalDateTime dataAtualizacao;

    @OneToOne(mappedBy = "user", cascade = CascadeType.ALL, orphanRemoval = true)
    private Perfil perfil;

    @OneToMany(mappedBy = "usuario1")
    private List<Amizade> amizades = new ArrayList<>();

    @OneToMany(mappedBy = "destinatario")
    private List<PedidoAmizade> pedidosRecebidos = new ArrayList<>();

    @OneToMany(mappedBy = "remetente")
    private List<PedidoAmizade> pedidosEnviados = new ArrayList<>();

    @OneToMany(mappedBy = "autor")
    private List<Publicacao> publicacoes = new ArrayList<>();
}

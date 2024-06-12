package primos.soga.mensagem;

import org.hibernate.query.criteria.JpaSearchedCase;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

import java.util.List;
import java.util.UUID;

public interface MensagemRepository extends JpaRepository<Mensagem, UUID>, JpaSpecificationExecutor<Mensagem> {

        List<Mensagem> findByRemetenteId(UUID remetenteId);
        List<Mensagem> findByDestinatarioId(UUID destinatarioId);
        List<Mensagem> findByRemetenteIdAndDestinatarioId(UUID remetenteId, UUID destinatarioId);

}

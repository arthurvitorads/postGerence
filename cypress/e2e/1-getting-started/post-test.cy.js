describe('Post CRUD Flow', () => {
  const email = 'arthur@gmail.com'
  const password = '123123'
  const title = 'Post de Teste'
  const updatedTitle = 'Post Atualizado'
  const description = 'Descrição do post de teste'

  before(() => {
    // Resetar estado se necessário
  })

  it('Faz login', () => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(password)
    cy.get('[data-testid="btn-submit"]').click()

    cy.url().should('include', '/posts')
  })

  it('Cria um novo post', () => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(password)
    cy.get('[data-testid="btn-submit"]').click()
    cy.url().should('include', '/posts')

    cy.get('.v-btn').contains('Criar Post').click()
    cy.get('[data-testid="input-title"]').type(title)
    cy.get('[data-testid="input-description"]').type(description)

    cy.get('[data-testid="btn-submit"]').click()

    cy.contains(title).should('exist')
    cy.contains(description).should('exist')
  })

  it('Edita o post', () => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(password)
    cy.get('[data-testid="btn-submit"]').click()
    cy.url().should('include', '/posts')

    cy.contains(title)
    .closest('.v-card')
    .within(() => {
        cy.contains('Editar').click()
    })

    cy.get('[data-testid="input-title"]').clear().type(updatedTitle)
    cy.get('[data-testid="btn-submit"]').click()

    cy.contains(updatedTitle).should('exist')
  })

    it('Exclui o post', () => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(password)
    cy.get('[data-testid="btn-submit"]').click()
    cy.url().should('include', '/posts')
    cy.contains(updatedTitle)
        .closest('.v-card')
        .within(() => {
        cy.contains('Excluir').click()
        })
    cy.on('window:confirm', () => true)
    cy.contains(title, { timeout: 7000 }).should('not.exist')
    })


  it('Faz logout', () => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(password)
    cy.get('[data-testid="btn-submit"]').click()
    cy.url().should('include', '/posts')
    cy.get('.v-btn').contains('Logout').click()
    cy.url().should('include', '/login')
  })
})
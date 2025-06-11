describe('Recuperação de senha', () => {
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/forgot-password')
    cy.get('[data-testid="input-email"]', { timeout: 10000 }).should('exist')
  })

  it('deve enviar link de recuperação com email válido', () => {
    cy.intercept('POST', '/forgot-password').as('postForgot')

    cy.get('[data-testid="input-email"]').type('teste1749600743429@exemplo.com')
    cy.get('[data-testid="btn-submit"]').click()

    cy.wait('@postForgot')
    cy.waitForSnackbar('Enviamos o link de recuperação para seu email!')
  })

  it('deve exibir erro com email inválido', () => {
    cy.intercept('POST', '/forgot-password').as('postForgot')

    cy.get('[data-testid="input-email"]').type('naoexiste@teste.com')
    cy.get('[data-testid="btn-submit"]').click()

    cy.wait('@postForgot')
    cy.waitForSnackbar('Não encontramos um usuário com esse email.')
  })
})

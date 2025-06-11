Cypress.Commands.add('waitForSnackbar', (message) => {
  cy.get('.v-snack__content', { timeout: 10000 })
    .should('be.visible')
    .and('contain.text', message)
})

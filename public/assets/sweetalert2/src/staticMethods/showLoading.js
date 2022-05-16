import * as dom from '../utils/dom/index.js'
import Swal from '../sweetalert2.js'
import { swalClasses } from '../utils/classes.js'

/**
 * Show spinner instead of Confirm button
 */
const showLoading = () => {
  let popup = dom.getPopup()
  if (!popup) {
    Swal.fire()
  }
  popup = dom.getPopup()
  const actions = dom.getActions()
  const confirmButton = dom.getConfirmButton()
  const loader = dom.getLoader()

  dom.show(actions)
  dom.hide(confirmButton)
  dom.addClass([popup, actions], swalClasses.loading)

  dom.show(loader)

  popup.setAttribute('data-loading', true)
  popup.setAttribute('aria-busy', true)
  popup.focus()
}

export {
  showLoading,
  showLoading as enableLoading
}

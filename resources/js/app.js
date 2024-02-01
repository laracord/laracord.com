import {
  Livewire,
  Alpine,
} from '../../vendor/livewire/livewire/dist/livewire.esm'

import Tooltip from '@ryangjchandler/alpine-tooltip'
import Clipboard from '@ryangjchandler/alpine-clipboard'
import notifications from 'alpinejs-notify'

Alpine.plugin(Tooltip)
Alpine.plugin(Clipboard)
Alpine.plugin(notifications)

Livewire.start()

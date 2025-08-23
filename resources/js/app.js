import {
  Livewire,
  Alpine,
} from '../../vendor/livewire/livewire/dist/livewire.esm'

import Tooltip from '@ryangjchandler/alpine-tooltip'
import Clipboard from '@ryangjchandler/alpine-clipboard'
import notifications from 'alpinejs-notify'
import intersect from '@alpinejs/intersect'

Alpine.plugin(Tooltip)
Alpine.plugin(Clipboard)
Alpine.plugin(notifications)
Alpine.plugin(intersect)

Livewire.start()

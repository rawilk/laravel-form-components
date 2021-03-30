# Changelog

All notable changes to `laravel-form-components` will be documented in this file

## 4.0.3 - 2021-03-30
### Fixed
- Fix issue with date-picker toggle icon trying to render for a `false` value
- Fix minor styling issues with flatpickr

## 4.0.2 - 2021-03-30
### Fixed
- Fix issue with inputs that have no leading addons having no border radius

## 4.0.1 - 2021-03-30
### Fixed
- Fix border radius issue with inputs that have leading addons
- Fix width issue for leading addons

## 4.0.0 - 2021-03-29
### Changed
- Inline most tailwind class names on form components
- Remove majority of styles from stylesheet
- Change styling from sass to css/postcss
- Enable border by default on `<x-form-group>` when it is inline and not the first child in a container
- Enable margins on `<x-form-group>` by default
- Change how `<x-custom-select>` "scrolls" to each option
- Switch any icons rendered with `svg()` helper to be rendered with `<x-dynamic-component />` blade component instead

### Added
- Add ability to specify grid columns on `<x-checkbox-group>` component (when inline)
- Add `$optional` and `$hint` attributes to `<x-form-group>` component

### Removed
- Remove `$fixedPosition` prop from `<x-custom-select>`

### Fixed
- Fix array to string conversion error on textarea when no value is passed in to it
- Prevent `$wire` from breaking `<x-custom-select>` when not used in a livewire component
- `<x-custom-select>` will now position itself correctly and will not require the `fixed-position` prop anymore (requires Popper.js)
- Add missing translations to form-components translation file
- Render timezone-select with correctly when using a component name prefix ([#16](https://github.com/rawilk/laravel-form-components/pull/16))

## 3.1.1 - 2021-03-01
### Fixed
- Prevent inputs from rendering the string `[]` when name is omitted

## 3.1.0 - 2021-02-24
### Added
- Add `extra-attributes` property to inputs to allow more options for attribute forwarding

## 3.0.6 - 2021-02-22
### Fixed
- Stop using strict comparison for finding a "selected" option in select component ([#11](https://github.com/rawilk/laravel-form-components/issues/11))

## 3.0.5 - 2021-02-03
### Fixed
- Fix bug with multiple custom select "selectedOption" not updating correctly and throwing JS errors

## 3.0.4 - 2021-01-22
### Updated
- Update flatpickr dependency to version `4.6.9`

## 3.0.3 - 2021-01-08
### Fixed
- Fix array to string conversion error with `<x-input>` on value field

## 3.0.2 - 2020-12-21
### Fixed
- Fix issue with `checked` attribute always being set to `false` on checkbox component

## 3.0.1 - 2020-12-18
### Fixed
- Fix issue on `custom-select` where options were always empty

## 3.0.0 - 2020-12-18
### Breaking Changes
- Drop support for php 7

### Added
- Add `container-class` prop to inputs
- Add language file for any text used in components
- Add switch toggle component (`<x-switch-toggle />`)

### Changed
- Allow `form-group` component label to be omitted by passing in `false` for `label`
- Update alpine dependency to version `2.8.0`
- Lighten up input placeholder color (apply `placeholder-gray-400` to inputs)

## 2.0.2 - 2020-11-30
### Added
- Add class `group` to custom select option elements

### Changed
- Change `x-if` to `x-show` on custom select button display

## 2.0.1 - 2020-11-30
### Added
- Add `custom-select-value-changed` event emitted on custom select

### Fixed
- Fix custom select empty id issue
- Fix custom select filter loading icon styles
- Fix date picker clear button styles
- Fix date picker styles when livewire re-renders it

## 2.0.0 - 2020-11-27
### Changed
- Change styling to be compatible with TailwindCSS v2
- Change color classes to more abstract names like `primary` or `danger` - see the [upgrade guide](https://randallwilk.dev/docs/laravel-form-components/v2/upgrade#styling) for more info
- `<x-custom-select>` component now renders options in an `x-for` loop and only accepts an array of options now
- `<x-custom-select>` component now uses `wire:filter` as a livewire method name to perform server-side filtering
- Change how alpine click event is registered on password component (from `@click` to `x-on:click`)
- Make `<x-timezone-select>` compatible with new api for `<x-custom-select>`
- Change default clear icon for `<x-custom-select>`

### Added
- Add `buttonDisplay` slot to `<x-custom-select>` component
- Add `optionDisplay` slot to `<x-custom-select>` component
- Add `wireListeners` property to `<x-custom-select>` component
- Add `$maxOptions` property to `<x-custom-select>` component
- Add ability for custom select options to be dependent on other custom selects
- Add php 8 support

### Removed
- Remove `<x-custom-select-option>` blade component
- Remove `array` type hint on `$options` attribute on `<x-custom-select>` to allow for more flexibility (i.e. passing in Collections)

## 1.4.14 - 2020-11-09
### Changed
- Change how custom select values are compared

## 1.4.13 - 2020-11-09
### Changed
- Change how custom select options are selected

## 1.4.12 - 2020-11-08
### Changed
- Allow timezone custom select to be fixed positioned

## 1.4.11 - 2020-11-08
### Changed
- Allow custom select menu to be fixed positioned instead of absolute
- Tweak password input styling

## 1.4.10 - 2020-11-02
### Fixed
- Prevent toggle icon from overlapping with icons injected into the password input by password managers such as Lastpass

## 1.4.9 - 2020-10-30
### Changed
- Change custom select option selection tracking to use session storage

## 1.4.8 - 2020-10-29
### Fixed
- Adjust how selected options are tracked for custom selects that are multiple selectable and wire filterable -- see [livewire issue #763](https://github.com/livewire/livewire/issues/763)
- Adjust selected display styling for multi custom-select

## 1.4.7 - 2020-10-28
### Fixed
- Fix z-index issue on custom select container
- Preserve custom select display if selected option disappears
- Prevent custom select options from being selected and de-selected in the same click
- Allow tab to work normally when pressed and custom select button trigger is focused
- Re-focus custom select trigger button when `esc` key is pressed and menu is opened
- Make custom select clear button always vertically centered

## 1.4.6 - 2020-10-26
### Fixed
- Add `wire:ignore` to the `custom-select` button display to prevent livewire from re-rendering it

## 1.4.5 - 2020-10-26
### Changed
- Update how `custom-select` is initialized

## 1.4.4 - 2020-10-26
Patch release for 1.4.3

## 1.4.3 - 2020-10-26
### Fixed
- [CustomSelect] Prevent trying to find children when $refs.menu is not present
- [CustomSelect] Prevent menu and container from being referenced if not present

## 1.4.2 - 2020-10-26
### Changed
- Allow form-group component to accept a `label-id` attribute to allow giving the label an id

## 1.4.1 - 2020-10-26
### Fixed
- Give custom select menu container a higher z-index to prevent it from appearing under other form inputs

## 1.4.0 - 2020-10-25
### Added
- Add new `custom-select` component ([#4](https://github.com/rawilk/laravel-form-components/issues/4))
- Add new `@fcJavaScript` blade directive for custom package JavaScript

### Changed
- Modify `@fcScripts` to output package JavaScript that powers custom components
- Change `timezone-select` to support using both native select and new `custom-select` component

## 1.3.2 - 2020-10-15
### Added
- Add `file-pond-clear` event listener to clear out all files in the FilePond instance

## 1.3.1 - 2020-10-15
### Added
- Add a `wire:model` watcher to the `file-pond` component to watch for manual file deletions

### Changed
- Change how FilePond is initialized on the `file-pond` component.

## 1.3.0 - 2020-10-14
### Added
- Add a file input component ([#2](https://github.com/rawilk/laravel-form-components/issues/2))
- Add a [FilePond](https://pqina.nl/filepond/) component ([#2](https://github.com/rawilk/laravel-form-components/issues/2))

### Changed
- Only render the id attribute on inputs if an id is set on the component

## 1.2.1 - 2020-10-12
### Changed
- Only render the checkbox/radio label markup if a label or description is present

## 1.2.0 - 2020-10-06
### Added
- Add a date picker component ([#7](https://github.com/rawilk/laravel-form-components/pull/7))
- Add directives `@fcStyles` and `@fcScripts` for linking to 3rd party CDN libraries when not in production ([view commit](https://github.com/rawilk/laravel-form-components/commit/5f923ec723c4295128150ee6aaecd4f6797cfafb))

### Changed
- Change format of timezone display in select options

## 1.1.1 - 2020-09-18
### Fixed
- Move x-cloak directive in x-password component to the toggle icon so autofocus can work properly on the input.

## 1.1.0 - 2020-09-16
### Added
- Add timezone select component

## 1.0.0 - 2020-09-13

- initial release

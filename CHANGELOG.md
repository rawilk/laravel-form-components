# Changelog

All notable changes to `laravel-form-components` will be documented in this file

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

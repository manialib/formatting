# Manialib\Formatting Change Log

## [4.0.2]

- $z was closing link even when no link was open

## [4.0.1]

- Automatically close link in html converter

## [4.0.0]

- Fix parsing of $< and $>
- Fix url converter
- Fix behavior when initializing with null string
- Auto escape html char during converting in html
- Fix link handling 

## [4.0.0-beta3]
### Breaking changes
- Renamed `\Manialib\Formatting\String` in `\Manialib\Formatting\ManialanetString`

## [4.0.0-beta2]
### Breaking changes
- HTML conversion with StringInterface::toHtml()
- Rename StringInterface::stripEscapeCharacter() to StringInterface::stripEscapeCharacters()

## [4.0.0-beta] - 2015-01-29
### Added
- Various information to prepare first release
- PHP Unit tests

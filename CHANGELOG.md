# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [unreleased] - 2018-11-12
### Added
- Ability to get request parameters
- Ability to create Filterable from request and from Filterable itself
- Feature to Eager load Relations from requests
- Order field and order direction to be set on URL like page and limit
- Ability to change name of the Filterable Request parameters
### Changed
- Renamed Builder class into FilterableFactory
- Every read operation signature now require Filterable instance
- Filterable parameter is now optionally in every method

## [1.2.0] - 2018-11-12
### Added
- Unit and Integration and unit tests
- Travis Ci automated tests
- CHANGELOG.md
### Changed
- Renamed PrimoService Provider class to LaravelServiceProvided and ServiceProvider class into PrimoServiceProvider

## [1.1.2] - 2018-11-08
### Fixed
- Request issue on Lumen

## [1.1.1] - 2018-11-01
### Added
- Lumen Support

## [1.1.0] - 2018-05-16
### Changed
- Split Crud repository unto php Traits

## [1.0.2] - 2018-05-14
### Fixed
- Query params was not preserved in in pagination links

## [1.0.1] - 2018-05-07
### Fixed
- Stability Issues

## [1.0.0] - 2018-05-07
### Added
- ServiceProvider
- Repository Implementation
- Crud Repository Implementation
- Filterable
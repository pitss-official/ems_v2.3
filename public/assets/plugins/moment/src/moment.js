//! moment.js
//! version : 2.10.6
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com

import {hooks as moment, setHookCallback} from './lib/utils/hooks';
import {
    createInvalid as invalid,
    createInZone as parseZone,
    createLocal as local,
    createUnix as unix,
    createUTC as utc,
    isMoment,
    max,
    min,
    momentPrototype as fn
} from './lib/moment/moment';

import {
    defineLocale,
    getLocale as localeData,
    getSetGlobalLocale as locale,
    listMonths as months,
    listMonthsShort as monthsShort,
    listWeekdays as weekdays,
    listWeekdaysMin as weekdaysMin,
    listWeekdaysShort as weekdaysShort
} from './lib/locale/locale';

import {
    createDuration as duration,
    getSetRelativeTimeThreshold as relativeTimeThreshold,
    isDuration
} from './lib/duration/duration';

import {normalizeUnits} from './lib/units/units';

import isDate from './lib/utils/is-date';

moment.version = '2.10.6';

setHookCallback(local);

moment.fn = fn;
moment.min = min;
moment.max = max;
moment.utc = utc;
moment.unix = unix;
moment.months = months;
moment.isDate = isDate;
moment.locale = locale;
moment.invalid = invalid;
moment.duration = duration;
moment.isMoment = isMoment;
moment.weekdays = weekdays;
moment.parseZone = parseZone;
moment.localeData = localeData;
moment.isDuration = isDuration;
moment.monthsShort = monthsShort;
moment.weekdaysMin = weekdaysMin;
moment.defineLocale = defineLocale;
moment.weekdaysShort = weekdaysShort;
moment.normalizeUnits = normalizeUnits;
moment.relativeTimeThreshold = relativeTimeThreshold;

export default moment;

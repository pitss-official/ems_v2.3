// Side effect imports
import './prototype';

import {defineLocale, getLocale, getSetGlobalLocale} from './locales';

import {listMonths, listMonthsShort, listWeekdays, listWeekdaysMin, listWeekdaysShort} from './lists';
import {deprecate} from '../utils/deprecate';
import {hooks} from '../utils/hooks';
import './en';

export {
    getSetGlobalLocale,
    defineLocale,
    getLocale,
    listMonths,
    listMonthsShort,
    listWeekdays,
    listWeekdaysShort,
    listWeekdaysMin
};

hooks.lang = deprecate('moment.lang is deprecated. Use moment.locale instead.', getSetGlobalLocale);
hooks.langData = deprecate('moment.langData is deprecated. Use moment.localeData instead.', getLocale);


import React from 'react';
import SVG from 'react-inlinesvg';

import '../../css/admin/shared/icon.scss';
import Tooltip from './Tooltip';

import IconAdjustable from '../../icons/admin/adjustable.svg';
import IconBold from '../../icons/admin/bold.svg';
import IconClock from '../../icons/admin/clock.svg';
import IconClose from '../../icons/admin/close.svg';
import IconCode from '../../icons/admin/code.svg';
import IconCheckboxAlternate from '../../icons/admin/checkbox-alternate.svg';
import IconCheckboxChecked from '../../icons/admin/checkbox-checked.svg';
import IconCheckboxEmpty from '../../icons/admin/checkbox-empty.svg';
import IconCheckmark from '../../icons/admin/checkmark.svg';
import IconDuplicate from '../../icons/admin/duplicate.svg';
import IconDrag from '../../icons/admin/drag.svg';
import IconEye from '../../icons/admin/eye.svg';
import IconItalic from '../../icons/admin/italic.svg';
import IconLink from '../../icons/admin/link.svg';
import IconMerge from '../../icons/admin/merge.svg';
import IconPencil from '../../icons/admin/pencil.svg';
import IconPhoto from '../../icons/admin/photo.svg';
import IconQuestion from '../../icons/admin/question.svg';
import IconRestore from '../../icons/admin/restore.svg';
import IconStarEmpty from '../../icons/admin/star-empty.svg';
import IconStarFull from '../../icons/admin/star-full.svg';
import IconSubscript from '../../icons/admin/subscript.svg';
import IconSuperscript from '../../icons/admin/superscript.svg';
import IconTrash from '../../icons/admin/trash.svg';
import IconUnderline from '../../icons/admin/underline.svg';
import IconUnlink from '../../icons/admin/unlink.svg';
 
const icons = {
    adjustable: IconAdjustable,
    bold: IconBold,
    clock: IconClock,
    close: IconClose,
    code: IconCode,
    'checkbox-alternate': IconCheckboxAlternate,
    'checkbox-checked': IconCheckboxChecked,
    'checkbox-empty': IconCheckboxEmpty,
    checkmark: IconCheckmark,
    duplicate: IconDuplicate,
    drag: IconDrag,
    eye: IconEye,
    italic: IconItalic,
    link: IconLink,
    merge: IconMerge,
    pencil: IconPencil,
    photo: IconPhoto,
    question: IconQuestion,
    restore: IconRestore,
    'star-empty': IconStarEmpty,
    'star-full': IconStarFull,
    subscript: IconSubscript,
    superscript: IconSuperscript,
    trash: IconTrash,
    underline: IconUnderline,
    unlink: IconUnlink,
};

const Icon = (props) => {
    let icon = icons.hasOwnProperty(props.type) ? icons[props.type] : false;

    if ( !icon ) {
        return null;
    }

    const className = props.className ? `wprm-admin-icon ${props.className}` : 'wprm-admin-icon';

    return (
        <Tooltip content={props.title}>
            <span
                className={ className }
                onClick={props.onClick}
            >
                <SVG
                    src={icon}
                />
            </span>
        </Tooltip>
    );
}
export default Icon;
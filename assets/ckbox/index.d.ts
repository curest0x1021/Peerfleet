/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 */
import { Asset as Asset$1, Props as Props$1, ImageEditorProps as ImageEditorProps$1, ImageEditorFromUrlProps as ImageEditorFromUrlProps$1 } from '@ckbox/core';
export { version } from '@ckbox/core';
import * as react from 'react';
export { react as React };

type Asset = Asset$1;
type CoreDialogProps = Required<Props$1>['dialog'];
type CoreAssetsConfigProps = Props$1['assets'];
type CoreAssetsOnChooseProps = Required<Required<Props$1>['assets']>['onChoose'];
type DialogProps = Omit<Exclude<CoreDialogProps, boolean>, 'open'>;
type Props = Omit<Props$1, 'dialog'> & {
    dialog?: boolean | DialogProps;
};
type ImageEditorProps = Omit<ImageEditorProps$1, 'open'>;
type ImageEditorFromUrlProps = Omit<ImageEditorFromUrlProps$1, 'open'>;

/**
 * Creates an instance of CKBox and mounts it at supplied node.
 *
 * @param root instance's root element
 * @param props instance's config options
 */
declare const mount: (root: Element, props: Props) => {
    unmount: () => void;
};
/**
 * Creates an instance of CKBox's image editor and mounts it at supplied node.
 *
 * @param root instance's root element
 * @param props instance's config options
 */
declare const mountImageEditor: (root: Element, props: ImageEditorProps | ImageEditorFromUrlProps) => {
    unmount: () => void;
};

export { type Asset, type CoreAssetsConfigProps, type CoreAssetsOnChooseProps, type CoreDialogProps, type DialogProps, type ImageEditorFromUrlProps, type ImageEditorProps, type Props, mount, mountImageEditor };

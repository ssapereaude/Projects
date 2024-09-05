/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.UIManager;
import utils.Window;
import java.awt.Color;
import java.awt.Cursor;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;

/* 
 * extend 'JButton' -> set cursor to 'pointer' when hovering over the button
 */

public class Button extends JButton {

    private boolean isEnabled = true;

    public Button(String title) {
        super(title);
        UIManager.put("Button.select", Color.TRANSLUCENT);
        this.setBorder(BorderFactory.createEmptyBorder());
        this.setFocusable(false);
        this.addMouseListener(new MouseAdapter() {
            public void mouseEntered(MouseEvent e) {
                if (isEnabled) {
                    Window.frame.setCursor(Cursor.HAND_CURSOR);
                }
            }

            public void mouseExited(MouseEvent e) {
                Window.frame.setCursor(Cursor.DEFAULT_CURSOR);
            }
        });
    }

    public Button(String title, JFrame frame) {
        super(title);
        UIManager.put("Button.select", Color.TRANSLUCENT);
        this.setBorder(BorderFactory.createEmptyBorder());
        this.setFocusable(false);
        this.addMouseListener(new MouseAdapter() {
            public void mouseEntered(MouseEvent e) {
                if (isEnabled) {
                    frame.setCursor(Cursor.HAND_CURSOR);
                }
            }

            public void mouseExited(MouseEvent e) {
                frame.setCursor(Cursor.DEFAULT_CURSOR);
            }
        });
    }

    public void setIsEnabled(boolean isEnabled) {
        this.isEnabled = isEnabled;
        this.setEnabled(isEnabled);
    }

}
